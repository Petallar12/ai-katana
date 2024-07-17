<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Dataloki</title>

        <!-- Bootstrap CSS -->
        <link
            rel="stylesheet"
            href="{{ asset('assets/bootstrap/bootstrap.min.css') }}"
        />

        <!-- Custom Google Fonts CSS -->
        <link
            rel="stylesheet"
            href="{{ asset('assets/fonts/google-fonts.css') }}"
        />

        <!-- Custom Styles -->
        <link rel="stylesheet" href="{{ asset('css/landing.css') }}" />
    </head>

    <body>
        <!-- Header -->
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container mt-4">
                    <img
                        class="logo"
                        src="/assets/images/purple-logo.png"
                        alt="Datalokey Logo"
                    />
                </div>
            </nav>
        </header>

        <!-- Main -->
        <main
            class="d-flex align-items-center justify-content-center"
            style="flex-grow: 1"
        >
            <section class="container text-center">
                <h1 class="title-header">Welcome to Datalokey</h1>
                <p class="title-text">
                    Our exclusive in-house platform for managing international
                    health insurance clients.
                </p>

                <!-- Cards -->
                <div class="row">
                    <div class="col-md-4">
                        <div
                            class="mb-3 bg-transparent animate-card"
                            data-delay="0.2s"
                        >
                            <div class="card-body">
                                <h2 class="card-title">IPMI Dashboard</h2>
                                <p class="card-text">
                                    Datalokey provides valuable insights into
                                    sales and commission trends, helping us make
                                    informed business decisions.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div
                            class="mb-3 bg-transparent animate-card"
                            data-delay="0.2s"
                        >
                            <div class="card-body">
                                <h2 class="card-title">Client Database</h2>
                                <p class="card-text">
                                    Datalokey allows us to easily manage our
                                    clients' information in one place, including
                                    their policy details and claims.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div
                            class="mb-3 bg-transparent animate-card"
                            data-delay="0.2s"
                        >
                            <div class="card-body">
                                <h2 class="card-title">
                                    Case Closures & Renewals
                                </h2>
                                <p class="card-text">
                                    Track case closures and policy renewals
                                    efficiently,
                                    <br />keeping our team organized and
                                    <br />up-to-date.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enter Button -->
                <div class="">
                    <a href="/login" class="enterBtn"
                        >Enter</a
                    >
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="text-white mt">
            <section class="text-white mt-2 py-2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p class="footer-text">
                                &copy; {{ date("Y") }} <b style="color: #5046e5;">Datalokey</b>. All rights
                                reserved.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </footer>

        <!-- Offline JS -->
        <script src="{{ asset('assets/bootstrap-js/bootstrap.bundle.min.js') }}"></script>

        <script>
            // Set animation delays for cards
            document
                .querySelectorAll('.animate-card')
                .forEach((card, index) => {
                    card.style.animationDelay = `${index * 0.3}s`;
                });
        </script>
    </body>
</html>
