@if(\Illuminate\Support\Facades\Session::has('status'))

    <script>
        new Noty({
                    type:"{{ Session::get('status') }}",
                    layout:"topRight",
                    text:"{{ Session::get('message') }}"
                }).show()
    </script>

@endif
