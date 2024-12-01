<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Note;
use Illuminate\Http\Request;
use App\Services\Operations;

class MainController extends Controller
{
    # Show home view
    public function index()
    {
        # Load user's nodes
        $id = session('user.id');
        $notes = User::find($id)->notes()->whereNull('deleted_at')->get()->toArray();

        # Show home view
        return view('home', ['notes' => $notes]);
    }

    # Show new_note view
    public function newNote()
    {
        return view("new_note");
    }

    # New notes submit
    public function newNoteSubmit(Request $request)
    {

        # Validate request
        $request->validate(
            # Rules
            [
                "text_title" => "required|min:3|max:200",
                "text_note" => "required|min:3|max:3000"
            ],
            # Error messages
            [
                'text_title.required' => 'O título é obrigatório.',
                'text_title.min' => 'O título deve ter pelo menos :min caracteres.',
                'text_title.max' => 'O título deve ter no máximo :max caracteres.',

                'text_note.required' => 'O texto é obrigatório.',
                'text_note.min' => 'O texto deve ter pelo menos :min caracteres.',
                'text_note.max' => 'O texto deve ter no máximo :max caracteres.'
            ]
        );

        # Get User
        $id = session('user.id');

        # Create new Note
        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        # Redirect to home
        return redirect()->route('home');
    }

    # Show edit_note view
    public function editNote($id)
    {
        # Decrypt id
        $id = Operations::decrypyId($id);

        # Load note
        $note = Note::find($id);

        # Show edit note view
        return view('edit_note', ['note' => $note]);
    }

    # Edit notes submit
    public function editNoteSubmit(Request $request)
    {
        # Validate request
        $request->validate(
            # Rules
            [
                "text_title" => "required|min:3|max:200",
                "text_note" => "required|min:3|max:3000"
            ],
            # Error messages
            [
                'text_title.required' => 'O título é obrigatório.',
                'text_title.min' => 'O título deve ter pelo menos :min caracteres.',
                'text_title.max' => 'O título deve ter no máximo :max caracteres.',

                'text_note.required' => 'O texto é obrigatório.',
                'text_note.min' => 'O texto deve ter pelo menos :min caracteres.',
                'text_note.max' => 'O texto deve ter no máximo :max caracteres.'
            ]
        );

        # Check if note_id exists
        if ($request->note_id == null) {
            return redirect()->route('home');
        }

        # Decrypt note_id
        $id = Operations::decrypyId($request->note_id);

        # Load note
        $note = Note::find($id);

        # Update note
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        # Redirect to home
        return redirect()->route('home');
    }

    # Show delete_note view
    public function deleteNote($id)
    {
        # Decrypt id  
        $id = Operations::decrypyId($id);

        # Load note
        $note = Note::find($id);

        # Show delete note confirmation
        return view('delete_note', ['note' => $note]);
    }

    # Delete note
    public function deleteNoteConfirm($id)
    {
        # Decrypt id
        $id = Operations::decrypyId($id);

        # Load note
        $note = Note::find($id);

        # 1. Hard delete
        // $note->delete();

        # 2. Soft delete
        // $note->deleted_at = date('Y:m:d H:i:s');
        // $note->save();

        # 3. Soft delete (property SoftDeletes in model)
        $note->delete();

        # 4. Hard delete (property SoftDeletes in model)
        // $note->forceDelete();

        # Redirect to home
        return redirect()->route('home');
    }
}
