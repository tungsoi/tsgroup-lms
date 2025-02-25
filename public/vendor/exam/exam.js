let questionCount = 0;
let mode = 'create';
const currentUrl = window.location.href;
if (currentUrl.match(/\/admin\/exams\/\d+\/edit\?mode=reload/)) {
    mode = 'edit';
}
if (mode === 'create') {
    $('#add-question').click(function () {
        questionCount++;
        const questionHTML = `
                    <div class="question-container card p-3 mb-3" id="question-${questionCount}">
                        <h5>Câu hỏi ${questionCount}</h5>
                        <input type="text" placeholder="Nhập câu hỏi" class="form-control mb-2 question-input" id="question-${questionCount}" name="question-${questionCount}">
                        <div class="answers" id="answers-${questionCount}">
                            <button class="add-answer btn btn-success btn-sm mb-2" type="button">Thêm câu trả lời</button>
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th style="width: 1%; white-space: nowrap;">Đáp án đúng</th>
                                        <th>Câu trả lời</th>
                                        <th style="width: 1%; white-space: nowrap;">#</th>
                                    </tr>
                                </thead>
                                <tbody id="answers-list-${questionCount}">
                                </tbody>
                            </table>
                            <button class="remove-question-btn btn btn-danger btn-sm" type="button">Xóa câu hỏi</button>
                        </div>
                    </div>
                `;
        $('#questions-container').append(questionHTML);
    });

    $(document).on('click', '.add-answer', function () {
        const questionId = $(this).closest('.question-container').attr('id').split('-')[1];
        const answerId = Date.now(); // Sử dụng timestamp làm ID cho đáp án
        const answerHTML = `
                    <tr class="answer">
                        <td class="text-center">
                            <input type="checkbox" class="answer-correct" id="correct-answer-${questionId}-${answerId}" name="correct-answer-${questionId}-${answerId}">
                        </td>
                        <td>
                            <input type="text" placeholder="Nhập câu trả lời" class="form-control answer-input" id="answer-${questionId}-${answerId}" name="answer-${questionId}-${answerId}">
                        </td>
                        <td class="text-center">
                            <button class="remove-answer btn btn-danger btn-sm" type="button">Xóa</button>
                        </td>
                    </tr>
                `;
        $(`#answers-list-${questionId}`).append(answerHTML);
    });

    $(document).on('click', '.remove-answer', function () {
        $(this).closest('tr').remove();
    });

    $(document).on('change', '.answer-correct', function () {
        const questionId = $(this).closest('.question-container').attr('id').split('-')[1];
        $(`#answers-${questionId} .answer-correct`).not(this).prop('checked', false);
    });

    $(document).on('click', '.remove-question-btn', function () {
        $(this).closest('.question-container').remove();
        $('#questions-container .question-container').each(function (index) {
            $(this).find('h5').text(`Câu hỏi ${index + 1}`);
        });
    });
}

function examLoadData(flag = false) {
    var hiddendata = $("input.content").val();
    var inputData = JSON.parse(hiddendata);
    var data = {
        "questions": inputData.questions.map(function (question) {
            return {
                "id": parseInt(question.id), // Chuyển đổi ID thành số
                "content": question.content, // Chỉnh sửa nội dung câu hỏi
                "answers": question.answers.map(function (answer) {
                    return {
                        "content": answer.content, // Giữ nguyên nội dung câu trả lời
                        "is_correct": answer.is_correct // Giữ nguyên trạng thái đúng
                    };
                })
            };
        })
    };

    function loadFormData() {
        data.questions.forEach((question, questionIndex) => {
            const questionHTML = `
                        <div class="question-container card p-3 mb-3" id="question-${question.id}">
                            <h5>Câu hỏi ${questionIndex + 1}</h5>
                            <input type="text" placeholder="Nhập câu hỏi" class="form-control mb-2 question-input" id="question-${question.id}" name="question-${question.id}" value="${question.content}">
                            <div class="answers" id="answers-${question.id}">
                                <button class="add-answer btn btn-success btn-sm mb-2" type="button">Thêm câu trả lời</button>
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <th style="width: 1%; white-space: nowrap;">Đáp án đúng</th>
                                            <th>Câu trả lời</th>
                                            <th style="width: 1%; white-space: nowrap;">#</th>
                                        </tr>
                                    </thead>
                                    <tbody id="answers-list-${question.id}">
                                    </tbody>
                                </table>
                                <button class="remove-question-btn btn btn-danger btn-sm" type="button">Xóa câu hỏi</button>
                            </div>
                        </div>
                    `;
            $('#questions-container').append(questionHTML);

            // Load answers for the current question
            question.answers.forEach((answer, answerIndex) => {
                const answerHTML = `
                            <tr class="answer">
                                <td class="text-center">
                                    <input type="checkbox" class="answer-correct" id="correct-answer-${question.id}-${answerIndex + 1}" name="correct-answer-${question.id}-${answerIndex + 1}" ${answer.is_correct ? 'checked' : ''}>
                                </td>
                                <td>
                                    <input type="text" placeholder="Nhập câu trả lời" class="form-control answer-input" id="answer-${question.id}-${answerIndex + 1}" name="answer-${question.id}-${answerIndex + 1}" value="${answer.content}">
                                </td>
                                <td class="text-center">
                                    <button class="remove-answer btn btn-danger btn-sm" type="button">Xóa</button>
                                </td>
                            </tr>
                        `;
                $(`#answers-list-${question.id}`).append(answerHTML);
            });
        });
    }

    // Load the form with data when page loads
    loadFormData();

    $(document).on('click', '.add-answer', function () {
        const questionId = $(this).closest('.question-container').attr('id').split('-')[1];
        const answerId = Date.now(); // Sử dụng timestamp làm ID cho đáp án
        const answerHTML = `
                    <tr class="answer">
                        <td class="text-center">
                            <input type="checkbox" class="answer-correct" id="correct-answer-${questionId}-${answerId}" name="correct-answer-${questionId}-${answerId}">
                        </td>
                        <td>
                            <input type="text" placeholder="Nhập câu trả lời" class="form-control answer-input" id="answer-${questionId}-${answerId}" name="answer-${questionId}-${answerId}">
                        </td>
                        <td class="text-center">
                            <button class="remove-answer btn btn-danger btn-sm" type="button">Xóa</button>
                        </td>
                    </tr>
                `;
        $(`#answers-list-${questionId}`).append(answerHTML);
    });

    $(document).on('click', '.remove-answer', function () {
        $(this).closest('tr').remove();
    });

    $(document).on('change', '.answer-correct', function () {
        const questionId = $(this).closest('.question-container').attr('id').split('-')[1];
        $(`#answers-${questionId} .answer-correct`).not(this).prop('checked', false);
    });

    $(document).on('click', '.remove-question-btn', function () {
        $(this).closest('.question-container').remove();
        $('#questions-container .question-container').each(function (index) {
            $(this).find('h5').text(`Câu hỏi ${index + 1}`);
        });
    });
}