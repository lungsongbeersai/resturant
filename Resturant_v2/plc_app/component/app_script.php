    <div id="show_session"></div>

    <div class="modal fade dialogbox" id="modal_logout" data-bs-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sending $50 to John</h5>
                </div>
                <div class="modal-body">
                    Are you sure about that?
                </div>
                <div class="modal-footer">
                    <div class="btn-list">
                        <a href="#" class="btn btn-text-primary btn-block" data-bs-dismiss="modal">
                            <ion-icon name="checkmark-outline"></ion-icon>
                            SEND
                        </a>
                        <a href="#" class="btn btn-text-danger btn-block" data-bs-dismiss="modal">
                            <ion-icon name="close-outline"></ion-icon>
                            CANCEL
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="assets/js/lib/bootstrap.bundle.min.js"></script>
    <!-- Ionicons -->
    <!-- <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script> -->
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
    <!-- Splide -->
    <script src="assets/js/plugins/splide/splide.min.js"></script>
    <!-- Base Js File -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/base.js"></script>
    <script src="assets/js/library.js"></script>
    <script src="assets/js/cleave.min.js"></script>
    <script src="assets/js/numeral.min.js"></script>
    <script src="https://cdn.socket.io/4.5.0/socket.io.min.js" integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous"></script>
    <script src="../assets/js/socket_connect.js"></script>
    <script>
        AddtoHome("2000", "once");

        function active_item(id_link){
           $.ajax({
            url:"service/fetch/fetch-all.php?active_item",
            method:"POST",
            data:{id_link},
            success:function(data){
                $("#show_session").html(data);
                // location.reload();
            }
           })
        }

    </script>