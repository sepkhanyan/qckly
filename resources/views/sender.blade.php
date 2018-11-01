<form action="/message" method="post">
    {{ csrf_field() }}
    <input type="text" name="message">
    <input type="submit">
</form>