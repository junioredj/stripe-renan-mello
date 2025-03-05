<!DOCTYPE html>
<html lang="pt-br">
<head>
    @include('globals.head')

    <script type="text/javascript" src="/js/java.js"></script>
    <link rel="stylesheet" href="../css/style.css">

    <script>
        $('.toast').toast(true)
    </script>
    <title>Document</title>
</head>
<body>



    <!-- Barra lateral -->
    <div class="d-flex">
        <aside class="sidebar" id="sidebar">
            <div class="d-flex justify-content-end  w-100">
            <div class="sidebar-toggle" onclick="toggleSidebar()">☰</div>
            </div>
            <a href="/"><i class="fa-solid fa-house"></i><span> Home</span></a>


            @if(Auth::check() && Auth::user()->admin == "1")

            <a href="{{ route('dashboard') }}"><i class="fa-solid fa-lock"></i><span>Admin</span></a>
            @endif

            <a href="{{ route('licencas') }}"><i class="fa-solid fa-certificate"></i><span>Licenças</span></a>

            <a href="{{ route('logout') }}"><i class="fa-solid fa-arrow-right-from-bracket text-danger"></i><span>Sair</span></a>
        </aside>

    <div class="conteudo-principal w-100">
        @if(Session::has('msg'))

        <script>
            Swal.fire(
                '{{session()->get("msg")}}',
                '',
                'success'
                )
        </script>
    @elseif(Session::has('error'))
    <script>
        Swal.fire(
            '{{session()->get("error")}}',
            '',
            'error'
            )
    </script>
    @endif
    @yield('conteudo')
    </div>

</div>






    <script>
            function toggleSidebar() {
                const sidebar = document.getElementById("sidebar");
                sidebar.classList.toggle("collapsed");
            }
        </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script src="/js/jquery.js"></script>

</body>
</html>
