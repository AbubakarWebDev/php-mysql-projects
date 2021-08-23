<!-- Admin Panel Footer -->
<?php
    if ((basename($_SERVER["PHP_SELF"]) !== "index.php") && (basename($_SERVER["PHP_SELF"]) !== "forgot-passsword.php") && (basename($_SERVER["PHP_SELF"]) !== "reset-passsword.php")) {
        echo "
        <footer>
            <div class='copyright-area'>
                Copyright © 2019-<?php echo date('Y'); ?>&nbsp;&nbsp;<a class='tm-link' target='_blank' href='https://techmemorise.blogspot.com/' title='Tech Memorise'>Tech Memorise</a>&nbsp;&nbsp;|&nbsp;&nbsp;All Rights Reserved
            </div>
        </footer>"; 
    }    
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>

<script>
    function showMessage(selector, type, slogan, mymassage) {
        let massage = document.querySelector(selector);
        massage.innerHTML =
            `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <strong>${slogan}</strong> ${mymassage}.
                <button type="button" style="padding: 1.25rem 1rem !important;" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
            </div>`;
    }
</script>
</body>

</html>