<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form id="form">
    <label for="column">Количество</label>
    <input type="text" id="column" name="column">

    <label for="type">Тип</label>
    <select name="type[]" id="type" multiple>
        <option value="type1">2 обыкн. фл.</option>
        <option value="type2">2 ворот. фл.</option>
        <option value="type3">1 обык. + 1 ворот</option>
    </select>

    <label for="diameter">Диаметр фланцев</label>
    <select name="diameter" id="diameter" multiple>
        <option value="300" name="300">300</option>
        <option value="250" name="250">250</option>
        <option value="200">200</option>
        <option value="150">150</option>
        <option value="100">100</option>
        <option value="80">80</option>
        <option value="65">65</option>
        <option value="50">50</option>
        <option value="40">40</option>
        <option value="32">32</option>
        <option value="25">25</option>
        <option value="20">20</option>
        <option value="15">15</option>
    </select>
    <br>
    <br>
    <button type="submit" name="submit">Отправить</button>
</form>
<div id="result">
    <table id="example"></table>
</div>
<script
    src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
    crossorigin="anonymous"></script>
<script>
    $('#form').on('submit', function (event) {
        event.preventDefault();

        let column = $('#column').val();
        let type = $('#type').val();
        let diameter = $('#diameter').val();
        $.ajax({
            url: '/page1',
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                column: column,
                type: type,
                diameter: diameter,
            },
            success: function (response) {
               let result = response.result;
                let keys;
                let values;
                let rows = [];
               result.forEach((item, idx) => {
                   keys = Object.keys(item);
                   values = Object.values(item)

                   let row = '<tr>';

                   keys.forEach((elem, keys) => {
                       row += '<td>' + elem + '</td>';
                       row += '<td>' + values[keys] + '</td>';
                       row += '';

                   })
                   row += '</tr>';
                   rows.push(row)
               })
                $('#example').html(rows)

            }
        })
    })
</script>

</body>
</html>
