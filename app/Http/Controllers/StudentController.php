<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\Models\Student; 
use Illuminate\Support\Facades\Auth;
// use Validator;
// use Illuminate\Validation\Rule;
use DB;

class StudentController extends Controller
{
  public $successStatus = 200;
  public function create(Request $request){
        $data=[];
        $input=$request->all();
        $input['password']=bcrypt($input['password']); 
        $student=Student::create($input);
        $data['firstname']  =$student->fname;     
        $data['lastname']  =$student->lname;     
        $data['email']  =$student->email;     
        $data['mobile']  =$student->mobile;     
        $data['age']  =$student->age;     
        $data['address']  =$student->address; 
        $data['token'] =$student->createToken('myApp')-> accessToken;
        return response()->json(['status'=>'success','success'=>$data,'message'=>'Registerd successfully'], $this-> successStatus);   
        }   
public function show(){
	    $data=[];
    	$student = DB::table('students')
        ->select('fname', 'lname','email','age','mobile','address')
        ->get();
    	if($student){
    	$data['student details']=$student;
    	return 	response()->json(['success'=>$data], $this-> successStatus);
        }else{
    	return response()->json(['error'=>'not found data'], 401);
       }
     }
public function update(Request $request, $id){
	   $data=[];
	   $input=$request->all();
	   $array=[
       'fname'=>$input['fname'],
       'lname'=>$input['lname'],
       'email'=>$input['email'],
       'age'=>$input['age'],
       'mobile'=>$input['mobile'],
       'address'=>$input['address'],
	   ];
	   $student=Student::where(['id'=>$id])->update($array);
	   if($student){
	   return response()->json(['status'=>'success','success'=>$data,'message'=>'Updated successfully'], $this-> successStatus);
	   }else{
	   return response()->json(['error'=>'not updated'],401);
	   }
      }
public function delete(Request $request, $id){
	   $data=[];
       $student=Student::find($id);
       $student->delete();
       if($student){
       return response()->json(['status'=>'success','message'=>'data deleted successfully'], $this-> successStatus);
       }else{
	   return response()->json(['status'=>'error','message'=>'data is emppty'], 401);
       }
      }
    }
