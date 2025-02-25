<div id="has-many-{{$column}}" class="has-many-{{$column}}">
    <div class="has-many-{{$column}}-forms">
        @foreach($forms as $pk => $form)
            <div class="has-many-{{$column}}-form fields-group">
                @foreach($form->fields() as $key_questions => $field)
                    {!! $field->render() !!}
                @endforeach
                @if($options['allowDelete'])
                    <div class="form-group form-group-{{ config('admin.form-style') }}">
                        <div class="col-sm-12">
                            <label class="{{$viewClass['label']}} control-label"></label>
                            <div class="{{$viewClass['field']}}">
                                <div class="remove btn btn-default btn-{{ config('admin.form-style') }} pull-right">
                                    <i class="fa fa-trash">&nbsp;</i>{{ trans('admin.remove-question') }}
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-8">
                            <div style="height: 20px; border-bottom: 1px solid #eee; text-align: center;margin-top: 20px;margin-bottom: 20px;">
                                <span style="font-size: 14px; background-color: #ffffff; padding: 0 10px;">
                                    Đáp án
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-12">
                                <label class="{{$viewClass['label']}} control-label"></label>
                                <div class="{{$viewClass['field']}} element-answers">
                                    @foreach ($form->model()->answers as $key => $answer)
                                        <div class="form-group  form-group-xs answer-item">
                                            <div class="col-sm-1">
                                                <div class="col-sm-8">
                                                    <input type="hidden"
                                                           name="questions[{{$pk}}][answer][new_{{$key+1}}][answer_id]"
                                                           value="{{ $answer->id }}">
                                                    <input type="checkbox"
                                                           name="questions[{{$pk}}][answer][new_{{$key+1}}][checkbox]"
                                                           value="correct"
                                                           @if ($answer->is_correct == 1) checked @endif>
                                                </div>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="input-group input-group-xs">
                                                        <span class="input-group-addon"><i
                                                                    class="fa fa-pencil fa-fw"></i></span>
                                                    <input type="text"
                                                           name="questions[{{$pk}}][answer][new_{{$key+1}}][content]"
                                                           class="form-control answer title"
                                                           placeholder="Nhập vào Nội dung câu hỏi"
                                                           value="{{ $answer->content }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="remove-answer btn btn-default btn-xs pull-right">
                                                    <i class="fa fa-trash"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label class="{{$viewClass['label']}} control-label"></label>
                                <div class="{{$viewClass['field']}}">
                                    <div class="add-answer btn btn-primary btn-{{ config('admin.form-style') }} pull-left">
                                        <i class="fa fa-plus"></i>&nbsp;{{ trans('admin.add-answer') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endif
            </div>
        @endforeach
    </div>
    <template class="{{$column}}-tpl">
        <div class="has-many-{{$column}}-form fields-group">
            @if (isset($template))
                {!! $template !!}
            @endif
            <div class="form-group form-group-{{ config('admin.form-style') }}">
                <div class="col-sm-12">
                    <label class="{{$viewClass['label']}} control-label"></label>
                    <div class="{{$viewClass['field']}}">
                        <div class="remove btn btn-default btn-{{ config('admin.form-style') }} pull-right">
                            <i class="fa fa-trash"></i>&nbsp;{{ trans('admin.remove-question') }}
                        </div>
                    </div>
                </div>
                <div class="col-sm-offset-2 col-sm-8">
                    <div style="height: 20px; border-bottom: 1px solid #eee; text-align: center;margin-top: 20px;margin-bottom: 20px;">
                        <span style="font-size: 14px; background-color: #ffffff; padding: 0 10px;">
                            Đáp án
                        </span>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="col-sm-12">
                        <label class="{{$viewClass['label']}} control-label"></label>
                        <div class="{{$viewClass['field']}} element-answers">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="{{$viewClass['label']}} control-label"></label>
                        <div class="{{$viewClass['field']}}">
                            <div class="add-answer btn btn-primary btn-{{ config('admin.form-style') }} pull-left">
                                <i class="fa fa-plus"></i>&nbsp;{{ trans('admin.add-answer') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </template>
    @if($options['allowCreate'])
        <div class="form-group form-group-{{ config('admin.form-style') }}">
            <label class="{{$viewClass['label']}} control-label"></label>
            <div class="{{$viewClass['field']}}">
                <div class="add btn btn-success btn-{{ config('admin.form-style') }}">
                    <i class="fa fa-plus"></i>&nbsp;{{ trans('admin.add-question') }}
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    $(document).on('click', '.add-answer', function (e) {

        let questions = $('.has-many-questions-form.fields-group').length;
        let questionInputName = $(this).parent().parent().parent().parent().parent().children().find('#title').attr('name'); // questions[new_1][title]
        questionInputName = questionInputName.split('[title]');
        let questionClassName = questionInputName[0];
        let answersNumber = $('.answer-item').length + 1;
        let answerClassName = questionClassName + '[answer][new_' + answersNumber + ']';


        let answer = '<div class="form-group  form-group-xs answer-item">' +
            '<div class="col-sm-1">' +
            '<div class="col-sm-8">' +
            '<input type="radio" name="' + answerClassName + '[checkbox]" value="correct">' +
            '</div>' +
            '</div>' +
            '<div class="col-sm-9">' +
            '<div class="input-group input-group-xs">' +
            '<span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>' +
            '<input type="text" name="' + answerClassName + '[content]" class="form-control answer title" placeholder="Nhập vào Nội dung câu hỏi">' +
            '</div>' +
            '</div>' +
            '<div class="col-sm-1">' +
            '<div class="remove-answer btn btn-default btn-xs pull-right">' +
            '<i class="fa fa-trash"></i>' +
            '</div>' +
            '</div>' +
            '</div>';

        $(this).parent().parent().parent().find('.element-answers').append(answer);
    });

    $(document).on('click', '.remove-answer', function (e) {
        $(this).parent().parent().remove();
    });

    // $(document).on('click', 'input[type="radio"]', function (e) {
    //     $(this).parent().parent().parent().parent().find('input[type="radio"]').prop("checked", false);
    //     $(this).prop("checked", true);
    // });
</script>
