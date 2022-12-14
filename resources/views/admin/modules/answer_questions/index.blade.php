@extends('master')
@section('name', 'Câu hỏi')
@section('endname', 'Danh sách')
@section('midname', 'Danh sách câu hỏi')
@section('content')
<?php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Session;
?>
<div class="col-12 p-1 pull-center">
    @if (Session::get('success'))
    <div class="alert alert-success alert-dismissible" id="tb">
        <button type="button" class="close" id="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i> Thông báo!</h5>
        {{ (Session::get('success')) }}
    </div>
    @endif
</div>
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Thêm, Sửa &amp; Xóa</h4>
        </div><!-- end card header -->
        <table id="example" class="table table-striped table-bordered" style="width:100%">           
            <div class="card-body">
                <div class="mt-3 mb-1">
                    <a href=" {{ route('admin.answerquestions.getcheckGenre', ['exam_id' => $exam_id]) }} " class="btn btn-success fw-600" class="">Tạo 1 câu hỏi mới</a>
                    <thead>
                        <tr>
                            <th scope="col" style="width: 12%;">STT</th>
                            <th scope="col" style="width: 12%;">Câu hỏi</th>
                            <th scope="col" style="width: 12%;">Đáp án</th>
                            <th scope="col" style="width: 12%;">Cấp độ</th>
                            <th scope="col" style="width: 12%;">Hình thức</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($answer_questions as $item)
                        <tr>
                            <td scope="row"> {{ $loop->iteration  }} </td>
                            <?php  
                                if($item->genre_id == 1) { 
                                $data_questions = json_decode($item->question, true); ?>
                                <td scope="col" style="width: 12%;">{{ $data_questions['question'] }}</td>
                            <?php    } ?>

                            <?php 
                                if(!empty($image)) {
                                $image = empty($item->image) ? 'imagedefault.jpg' : $item->image;
                                }
                            ?>

                            <?php  
                            if($item->genre_id == 1) { ?>
                                @if ($item->answer == 'a')
                                <td scope="col" style="width: 12%;">{{ $data_questions['a'] }}</td>
                                @elseif ($item->answer == 'b')
                                <td scope="col" style="width: 12%;">{{ $data_questions['b'] }}</td>
                                @elseif ($item->answer == 'c')
                                <td scope="col" style="width: 12%;">{{ $data_questions['c'] }}</td>
                                @elseif ($item->answer == 'd')
                                <td scope="col" style="width: 12%;">{{ $data_questions['d'] }}</td>
                                @else 
                                <td scope="col" style="width: 12%;">{{ $item->answer }}</td>
                                @endif
                            <?php } ?>

                            @if ($item->level == 1)
                                <td scope="col" style="width: 12%;">Dễ</td>
                            @elseif($item->level == 2)
                                <td scope="col" style="width: 12%;">Vừa</td>
                            @else
                                <td scope="col" style="width: 12%;">Khó</td>
                            @endif
                            <td scope="col" style="width: 12%;">{{ $item->genre_name }}</td>
                            <td scope="col"><a class="btn btn-success w-100" href="{{ route('admin.answerquestions.edit',['answerquestion_id' => $item->id]) }}">Chỉnh sửa</a></td>
                            <td scope="col"><a class="btn btn-danger w-100 delete" href="{{ route('admin.answerquestions.destroy',['answerquestion_id' => $item->id]) }}">Xóa</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="col" style="width: 12%;">STT</th>
                            <th scope="col" style="width: 12%;">Câu hỏi</th>
                            <th scope="col" style="width: 12%;">Đáp án</th>
                            <th scope="col" style="width: 12%;">Mức độ</th>
                            <th scope="col" style="width: 12%;">Hình thức</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </div>
            </div>
        <!-- end col -->
        </table>
    </div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js">
</script>
<script type="text/javascript">
    $(".delete").click(function() {
        flag = false;
        return confirm('Xóa câu hỏi?');
    }); 
</script>
@endsection