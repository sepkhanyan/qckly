<!DOCTYPE html>
<html>
<head>
    <title>Pusher Test</title>
    <script src="https://js.pusher.com/4.3/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/dojo/1.13.0/dojo/dojo.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('6dba162777e691fc6a70', {
            cluster: 'eu',
            forceTLS: true
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('new-message', function(data) {
            alert(JSON.stringify(data));
        });
    </script>
</head>
<body>
{{--<h1>Pusher Test</h1>--}}
{{--<p>--}}
    {{--Try publishing an event to channel <code>my-channel</code>--}}
    {{--with event name <code>my-event</code>.--}}
{{--</p>--}}
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <example></example>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>