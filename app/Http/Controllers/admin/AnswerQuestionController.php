<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\admin\AnswerQuestionRequest;

class AnswerQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($exam_id)
    {
        $data['answer_questions'] = DB::table('answer_questions')
            ->select('answer_questions.*', 'genres.name as genre_name', 'users.fullname as user_fullname', 'exams.name as exam_name')
            ->join('users', 'answer_questions.user_id', '=', 'users.id')
            ->join('genres', 'answer_questions.genre_id', '=', 'genres.id')
            ->join('exams', 'answer_questions.exam_id', '=', 'exams.id')
            ->ORDERBY('id', 'DESC')
            ->where('exam_id', $exam_id)
            ->get();
        $data['exam_id'] = $exam_id;
        // dd($data); 
        return view('admin.modules.answer_questions.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($exam_id, $genres_id)
    {
        // dd($genres_id);
        $data['genres'] = DB::table('genres')->where('id', $genres_id)->first();
        $exams = DB::table('exams')->where('id', $exam_id);
        if($exams->exists()) {
            $data['exams'] = $exams->first();
            // dd($data);
            return view("admin.modules.answer_questions.create", $data);
        }
        else {
            abort(404);
        }
    }

    public function getcheckGenre($exam_id)
    {
        $data['genres'] = DB::table('genres')->get();
        $exams = DB::table('exams')->where('id', $exam_id);
        if($exams->exists()) {
            $data['exams'] = $exams->first();
            return view('admin.modules.answer_questions.checkGenre', $data);
        }
        else {
            abort(404);
        }
     
    }

    public function postcheckGenre(Request $request, $exam_id)
    {
        $exams = DB::table('exams')->where('id', $exam_id);
        $genres = DB::table('genres')->where('id', $request->genre_id);
        if($exams->exists()) {
            $data['exams'] = $exams->first();
            $data['genres'] = $genres->first();
            // dd($data);
            return redirect()->route('admin.answerquestions.create', ['exam_id' => $exam_id, 'genres_id' => $request->genre_id]);
        }
        else {
            abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $exam_id)
    {
        dd($request);
        $exams = DB::table('exams')->where('id', $exam_id)->first();
        $data = $request->except('_token');
        $data['exam_id'] = $exams->id;
        $data['user_id'] = 1;
        $data['question'] = json_encode($request->question);
        if($request->image->getClientOriginalName() != null) {
            $imageName = time().'-'.$request->image->getClientOriginalName();  
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }

        $data['created_at'] = new \DateTime();
        DB::table('answer_questions')->insert($data);
        return redirect()->route('admin.exams.index', ['subject_id' => $exams->subject_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_exam, $id_answerquestion)
    {
        $data['exams'] = DB::table('exams')->where('id', $id_exam)->first();
        $exams = DB::table('answer_questions')->where('id', $id_answerquestion);
        if($exams->exists()) {
            $data['answer_questions'] = $exams->first();
            $data['genres'] = DB::table('genres')->where('id', $data['answer_questions']->genre_id)->first();
            $data['questions'] = json_decode($data['answer_questions']->question, true);
            // dd($data);
            return view("admin.modules.answer_questions.edit", $data);
        }
        else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnswerQuestionRequest $request, $id_exam, $id_answerquestion)
    {
        $data = $request->except('_token');
        $data['updated_at'] = new \DateTime();
        // dd($data);
        DB::table('answer_questions')->where('id', $id_answerquestion)->update($data);

        return redirect()->route('admin.answerquestions.index',['exam_id' => $id_exam]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_exam, $id_answerquestion)
    {
        $answer_questions = DB::table('answer_questions')->where('id', $id_answerquestion);
        if($answer_questions->delete()) {
            return redirect()->route('admin.answerquestions.index',['exam_id' => $id_exam]);
        }
        else {
            abort(404);
        }
    }
}