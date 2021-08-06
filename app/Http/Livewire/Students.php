<?php

namespace App\Http\Livewire;

use App\Models\Student;
use Livewire\Component;

class Students extends Component
{
    public $ids;
    public $firstname;
    public $lastname;
    public $email;
    public $phone;

    protected $rules = [
        'firstname' => 'required',
        'lastname' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
    ];

    public function resetInputFields(){
        $this->firstname = '';
        $this->lastname = '';
        $this->email = '';
        $this->phone = '';
    }

    public function store(){
        $this->validate();

        Student::create([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'phone' => $this->phone
        ]);
        session()->flash('message','Student has been added!');
        $this->resetInputFields();
        $this->emit('studentAdded');
    }

    public function edit($id){
        $student = Student::where('id',$id)->first();
        $this->ids = $student->id;
        $this->firstname = $student->firstname;
        $this->lastname = $student->lastname;
        $this->email = $student->email;
        $this->phone = $student->phone;

    }

    public function update(){
        $this->validate();
        if($this->ids){
            $student = Student::find($this->ids);

            $student->update([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'phone' => $this->phone
            ]);
            session()->flash('message', 'Student updated!');
            $this->resetInputFields();
            $this->emit('studentUpdated');
        }
    }

    public function render()
    {
        $students = Student::orderBy('id', 'DESC')->get();
        return view('livewire.students',['students' => $students]);
    }

    public function delete($id){
        Student::where('id',$id)->delete();
        session()->flash('message', 'Student deleted!');
        
    }
}
