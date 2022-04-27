<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Водители</title>

    <style>
        table {
            margin-top: 12px;
            text-align: left;
            border-collapse: collapse;
        }
        table td {
            border: 1px solid black;
            padding: 3px 6px;
        }
    </style>
</head>
<body>
<div>
    <a href="/">Использование автомобилей</a>
    <a href="/cars">Автомобили</a>
</div>
<div style="margin-top: 12px;">
    <form action="/users/create" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <label for="name">Имя водителя</label>
        <input type="text" name="name">
        <input type="submit" value="Добавить">
    </form>
</div>
<div>
    <table>
        <thead>
            <tr>
                <th>Имя водителя</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr user-id="{{ $user->id }}">
                    <td>{{ $user->name }}</td>
                    <td onclick="editUser({{ $user->id }})">Редактировать</td>
                    <td onclick="deleteUser({{ $user->id }})">Удалить</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function editUser(id) {
        let tr = document.querySelectorAll('tr[user-id="' + id + '"]')[0];
        let name = tr.children[0].innerText;
        tr.children[0].innerHTML = '<input type="text" value="' + name +'">';
        tr.children[1].setAttribute("onclick", 'saveUser(' + id + ')');
        tr.children[1].innerText = 'Сохранить';
        tr.children[2].setAttribute("onclick", 'cancelSave(' + id + ')');
        tr.children[2].innerText = 'Отменить';
        let hid = document.createElement('input');
        hid.type = 'hidden';
        hid.className = 'hidden-name';
        hid.value = name;
        tr.children[2].appendChild(hid);
    }

    function saveUser(id) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", '/users/edit', true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                location.reload();
            }
        }
        let name = document.querySelectorAll('tr[user-id="' + id + '"] input')[0].value;
        xhr.send("_token={{ csrf_token() }}&id=" + id + "&name=" + name);
    }

    function cancelSave(id) {
        let tr = document.querySelectorAll('tr[user-id="' + id + '"]')[0];
        tr.children[0].innerText = tr.querySelectorAll('input.hidden-name')[0].value;
        tr.children[1].setAttribute("onclick", 'editUser(' + id +')');
        tr.children[1].innerText = 'Редактировать';
        tr.children[2].setAttribute("onclick", 'deleteUser(' + id + ')');
        tr.children[2].innerText = 'Удалить';
    }

    function deleteUser(id) {
        let isSure = confirm("Удалить водителя?");
        if (!isSure) return false;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", '/users/remove', true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                location.reload();
            }
        }
        xhr.send("_token={{ csrf_token() }}&id=" + id);
    }
</script>
</body>
