<div class="container" id="exam-create">
    <button id="add-question" class="btn btn-primary btn-sm" type="button">Thêm câu hỏi</button>
    <br> <br>
    <div id="questions-container"></div>
</div>
<script>
    function getParam(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    $(document).ready(function() {
        const mode = getParam('mode');
        if (mode !== 'reload') {
            window.location.href = '?mode=reload';
        }

        const currentUrl = window.location.href;
        if (currentUrl.match(/\/admin\/exams\/\d+\/edit\?mode=reload/)) {
            examLoadData();
        }
    });
</script>