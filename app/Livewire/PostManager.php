<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostManager extends Component
{
    public $posts, $title, $content, $post_id;
    public $isOpen = false;

    public function render()
    {
        $this->posts = Post::with('user')->get();
        return view('livewire.post-manager');
    }

    public function create()
    {
        $this->resetInput();
        $this->isOpen = true;
    }

    public function edit($id)
    {
        $post = Post::find($id);
        $this->post_id = $id;
        $this->title = $post->title;
        $this->content = $post->content;
        $this->isOpen = true;
    }

    public function delete($id)
    {
        Post::find($id)->delete();
        session()->flash('message', 'Post deleted successfully.');
    }

    public function save()
    {
        $this->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        Post::updateOrCreate(['id' => $this->post_id], [
            'title' => $this->title,
            'content' => $this->content,
            'user_id' => Auth::id(),
        ]);

        session()->flash('message', $this->post_id ? 'Post updated successfully.' : 'Post created successfully.');
        $this->closeModal();
    }

    private function resetInput()
    {
        $this->title = '';
        $this->content = '';
        $this->post_id = '';
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInput();
    }
}
