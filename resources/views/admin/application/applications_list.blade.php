@extends('admin.layouts.admin-app')
@section('admin_content')
    {{--<h3 class="text-center">Заявки пользователя на вывод денег</h3>--}}
    <div class="mail-box-header">
        <h2 class="text-center">
            Заявки пользователя на вывод денег
        </h2>
    </div>
    <div class="mail-box">
        <table class="table table-hover table-mail">
            <thead>
            <tr>
                <th>Пользователь</th>
                <th>Сумма</th>
                <th>Тип</th>
                <th>Счет</th>
                <th>Дата</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($applications as $application)
                @if($application->status === 0)
                    <tr class="unread">
                        {{--<td class="check-mail">--}}
                        {{--<input type="checkbox"  class="i-checks" checked>--}}
                        {{--</td>--}}
                        <td><span class="label label-info pull-right">NEW</span><a
                                    href="{{route('users.show',$application->user_id)}}">{{$application->sender->name}}</a>
                        </td>
                        <td>{{$application->money_sum}} грн.</td>
                        <td class="">{{$application->type_cart}}</td>
                        <td class="">{{$application->number_score}}</td>
                        <td>{{$application->created_at}}</td>
                        <td>

                                <a href="{{route('proposal.show',$application->id)}}">
                                    <button class="btn btn-info dim"><i class="fa fa-info" aria-hidden="true"></i></button>
                                </a>
                                <form  action="{{route('proposal.destroy',$application->id)}}" method="post">
                                    <input type="hidden" name="_method" value="DELETE">
                                    {{csrf_field()}}
                                    <button type="submit" class="btn btn-danger dim" onclick="return checkDelete()"><i
                                                class="fa fa-trash" aria-hidden="true"></i></button>
                                </form>
                        </td>
                    </tr>
                @else
                    <tr class="read">
                        {{--<td class="check-mail">--}}
                        {{--<input type="checkbox"  class="i-checks" checked>--}}
                        {{--</td>--}}
                        <td><a href="{{route('users.show',$application->user_id)}}">{{$application->sender->name}}</a>
                        </td>
                        <td>{{$application->money_sum}} грн.</td>
                        <td>{{$application->type_cart}}</td>
                        <td>{{$application->number_score}}</td>
                        <td>{{$application->created_at}}</td>
                        <td>
                            <div>
                                <a href="{{route('proposal.show',$application->id)}}">
                                    <button class="btn btn-info dim">
                                        <i class="fa fa-info" aria-hidden="true"></i>
                                    </button>
                                </a>
                                <form class="form-inline btn_del" action="{{route('proposal.destroy',$application->id)}}" method="post">
                                    <input type="hidden" name="_method" value="DELETE">
                                    {{csrf_field()}}
                                    <button type="submit" class="btn btn-danger dim" onclick="return checkDelete()"><i
                                                class="fa fa-trash" aria-hidden="true"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('admin_script')
    <script>
        function checkDelete() {
            return confirm('Вы уверены ?');
        }
    </script>
@endsection
