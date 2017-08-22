<div class="footer">
    <div class="container">

        <div class="foter-bottom">
            <p class="footer-grid">Design by <a href="http://w3layouts.com/" target="_blank"></a> </p>
            <div class=" nav-top">
                <ul>
                    <li class="active" ><a href="index.html" class="scroll">Home</a></li>
                    <li><a href="about.html" class="scroll"> About</a></li>
                    <li><a href="teams.html" class="scroll">Team</a></li>
                    <li><a href="services.html" class="scroll">Services</a></li>
                    <li><a href="sports.html" class="scroll">Sports </a></li>
                    <li><a href="contact.html" class="scroll">Contact</a></li>
                </ul>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'

        }
    });
    $("img").error(function () {
        $(this).unbind("error").attr("src", $(this).attr('src'));
    });
</script>