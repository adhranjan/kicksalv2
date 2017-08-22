@if(\Illuminate\Support\Facades\Session::has('status'))

    <link href="{{ asset('assets/admin/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">


    <script src="{{ asset('assets/admin/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>
    <script>
        $(document).ready(function() {
            TabbedNotification = function(options) {
                var message = "<div id='ntf' class='text alert-" + options.type + "' style='display:none'><h2><i class='fa fa-bell'></i> " + options.title +
                        "</h2><div class='close'><a href='javascript:;' class='notification_close'><i class='fa fa-close'></i></a></div><p>" + options.text + "</p></div>";
                $('#custom_notifications #notif-group').append(message);
                $('.tabbed_notifications > div:first-of-type').show();

            };
            $(document).on('click', '.notification_close', function(e) {
                $('#ntf').remove();
                $('#ntlink').parent().remove();
                $('.notifications a').first().addClass('active');
                $('#notif-group div').first().css('display', 'block');
            });
            new TabbedNotification({
                title: '{{ Session::get('head') }}',
                text: '{{ Session::get('message') }}',
                type: '{{ Session::get('status') }}',
                sound: false
            })
        });
    </script>
@endif