<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">

<x-head />

<body>

    <!-- ..::  sidebar start ::.. -->
    <x-layout.sidebar />
    <!-- ..::  sidebar end ::.. -->

    <main class="dashboard-main">

        <!-- ..::  navbar start ::.. -->
        <x-layout.navbar />
        <!-- ..::  navbar end ::.. -->

        {{ $slot }}

        <!-- ..::  footer start ::.. -->
        <x-footer />
        <!-- ..::  footer end ::.. -->

    </main>

    <!-- ..::  scripts  start ::.. -->
    <x-script script='' />
    <!-- ..::  scripts  end ::.. -->

</body>

</html>

