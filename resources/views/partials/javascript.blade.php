<!-- JAVASCRIPT -->
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{ asset('assets/js/plugins.js') }}"></script>

<!-- apexcharts -->
<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- Vector map-->
<script src="{{ asset('assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
<script src="{{ asset('assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

<!--Swiper slider js-->
<script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>

<!-- Dashboard init -->
{{-- <script src="{{ asset('assets/js/pages/dashboard-ecommerce.init.js') }}"></script> --}}

<!-- App js -->
<script src="{{ asset('assets/js/app.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js" integrity="sha512-jTgBq4+dMYh73dquskmUFEgMY5mptcbqSw2rmhOZZSJjZbD2wMt0H5nhqWtleVkyBEjmzid5nyERPSNBafG4GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>

<script>
    function onAjaxError(err, statusCode = null) {
        Swal.fire({
            title: `Terjadi Kesalahan`,
            text: err.responseJSON?.message == undefined ? "Terjadi kesalahan saat memproses data!, Harap coba lagi" : err.responseJSON.message,
            icon: 'error',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        })
    }


    let a;
    let date;
    setInterval(() => {
        a = new Date();
        let minutes = a.getMinutes() < 10 ? `0${a.getMinutes()}` : a.getMinutes()
        let second = a.getSeconds() < 10 ? `0${a.getSeconds()}` : a.getSeconds()
        let hours = a.getHours() < 10 ? `0${a.getHours()}` : a.getHours()

        date = getDaysName() +', '+a.getDate() + ' ' + getMonthName(a.getMonth()) + ' ' +a.getFullYear() + ' | ' + hours + ':' + minutes + ':' + second + ' WIB'
        document.getElementById('current-time').innerHTML = date;
    }, 1000);

    function getMonthName(monthNumber) {
        const date = new Date();
        date.setMonth(monthNumber);

        return date.toLocaleString('id-ID', {
            month: 'long',
        });
    }

    function getDaysName() {
        const weekday = ["Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu"];

        const d = new Date();
        let day = weekday[d.getDay()];

        return day
    }
</script>
