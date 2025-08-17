<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Webpage_content as WebpageContent;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class WebpageContentManager extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $contents;
    public $file_path_local;
    public $storage_type = 1; // 1 = local, 2 = remote

    // Form fields
    public $type, $icon, $title, $short_description, $description;
    public $file_path, $display_position,$showImageVideItem = 1;
    public $is_highlight_item = 0, $is_active = 1;
    public $content_id;

    public $isEditing = false;

    public $search = '',$searchType;
    public $perPage = 10; // rows per page
    protected $paginationTheme = 'tailwind';
    public $isShowContentModal = false;

    protected $rules = [
        'type' => 'required|integer',
        'icon' => 'nullable|string|max:255',
        'title' => 'required|string|max:255',
        'short_description' => 'nullable|string|max:500',
        'description' => 'nullable|string',
        'storage_type' => 'required|integer',
        'file_path' => 'nullable|string|max:255',
        'display_position' => 'required|integer',
        'is_highlight_item' => 'boolean',
        'is_active' => 'required|integer',
    ];

    public $contentTypes = [
        1 => 'Why Choose',
        2 => 'About Us',
        3 => 'Service (Treatment)',
        4 => 'Emergency Service (Treatment)',
        5 => 'FAQ',
        6 => 'Testimonial',
        7 => 'Picture',
        8 => 'Video',
    ];
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }
    public function render()
    {
//        \Log::info('Searching for: ' . $this->searchType);
        $contents = WebpageContent::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                });
            })->when($this->searchType, function ($query) {
                $query->where(function ($q) {
                    $q->where('type', "$this->searchType");
                });
            })
            ->whereIn('is_active', [1, 2]) // Include both active and inactive records
            ->latest()
            ->paginate((int) $this->perPage);

        return view('livewire.webpage-content-manager', [
            'contentRecord' => $contents
        ]);
    }

    public function store()
    {
        try {
            $this->validate();

            $path = null;
            if ($this->storage_type == 1 && $this->file_path_local) {
                $path = $this->file_path_local->store('uploads', 'public'); // saves in storage/app/public/uploads
            } elseif ($this->storage_type == 2) {
                $path = $this->file_path; // remote path entered manually
            }

            WebpageContent::create([
                'type' => $this->type,
                'icon' => $this->icon,
                'title' => $this->title,
                'short_description' => $this->short_description,
                'description' => $this->description,
                'storage_type' => $this->storage_type,
                'file_path' => $path,
                'display_position' => $this->display_position ?? 0,
                'is_highlight_item' => $this->is_highlight_item,
                'is_active' => $this->is_active,
            ]);

            $this->resetForm();
            $this->isShowContentModal = false;

            // ✅ Success SweetAlert
            $this->dispatch('swal:success', [
                'title' => 'Saved!',
                'text'  => 'Your content has been added successfully.',
            ]);



        } catch (\Throwable $e) {
            // Log error for debugging
            \Log::error('Store content error: '.$e->getMessage());

            // ❌ Error SweetAlert
            $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text'  => 'Something went wrong while saving content.',
            ]);
        }
    }


    public function edit($id)
    {
        $this->isShowContentModal = true;
        $content = WebpageContent::findOrFail($id);
        $this->content_id = $content->id;
        $this->type = $content->type;
        $this->icon = $content->icon;
        $this->title = $content->title;
        $this->short_description = $content->short_description;
        $this->description = $content->description;
        $this->storage_type = $content->storage_type;
        $this->file_path = $content->file_path;
        $this->display_position = $content->display_position;
        $this->is_highlight_item = $content->is_highlight_item;
        $this->is_active = $content->is_active;

        $this->isEditing = true;
    }

    public function update()
    {
        try {
            $this->validate();

            $content = WebpageContent::findOrFail($this->content_id);

            $path = null;

            if (!empty($this->file_path_local) || !empty($this->file_path)) {
                // Check if a new file is uploaded or a remote path is provided
                if ($this->storage_type == 1 && $this->file_path_local) {
                    $path = $this->file_path_local->store('uploads', 'public'); // saves in storage/app/public/uploads
                } elseif ($this->storage_type == 2) {
                    $path = $this->file_path; // remote path entered manually
                }
            } elseif (!empty($content->file_path)) {
                $path = $content->file_path; // keep existing path if no new file uploaded
            }

            $content->update([
                'type'              => $this->type,
                'icon'              => $this->icon,
                'title'             => $this->title,
                'short_description' => $this->short_description,
                'description'       => $this->description,
                'storage_type'      => $this->storage_type,
                'file_path'         => $path,
                'display_position'  => $this->display_position,
                'is_highlight_item' => $this->is_highlight_item,
                'is_active'         => $this->is_active,
            ]);

            // Reset and close modal
            $this->resetForm();
            $this->isShowContentModal = false;

            // Success alert
            $this->dispatch('swal:success', [
                'title' => 'Saved!',
                'text'  => 'Your content has been updated successfully.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors gracefully (they'll also show in Livewire automatically)
            $this->dispatch('swal:error', [
                'title' => 'Validation Failed',
                'text'  => 'Please fix the highlighted errors and try again.',
            ]);
            throw $e; // keep default Livewire error bag working
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Update Content Error: '.$e->getMessage());

            // Show generic error alert
            $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text'  => 'Something went wrong while updating the content. Please try again.',
            ]);
        }
    }


    public $confirmingDeleteId = null;

    public function confirmDelete($id)
    {
        $this->confirmingDeleteId = $id;
    }

    public function delete()
    {
        if ($this->confirmingDeleteId) {
            WebpageContent::findOrFail($this->confirmingDeleteId)->update(['is_active' => 0]);
            $this->confirmingDeleteId = null;
        }
    }
    public function resetForm()
    {
        $this->type = '';
        $this->icon = '';
        $this->title = '';
        $this->short_description = '';
        $this->description = '';
        $this->storage_type = 1;
        $this->file_path = '';
        $this->display_position = '';
        $this->is_highlight_item = 0;
        $this->is_active = 1;

        $this->isEditing = false;
        $this->content_id = null;
    }

    public function helloChange(){
        if($this->storage_type==1){
            $this->storage_type == 2 ; // Clear remote path if local file is uploaded
        }
    }
    public function changeContentType(){
        if($this->type==7 || $this->type==8 ){
            $this->showImageVideItem = 2 ; // Clear remote path if local file is uploaded
        }else {
            $this->showImageVideItem = 1; // Clear remote path if local file is uploaded
        }
    }

    public function createContent()
    {
        $this->resetForm();
        $this->isShowContentModal = true;
    }
    public function closeContentForm()
    {
        $this->resetForm();
        $this->isShowContentModal = false;
    }


}
