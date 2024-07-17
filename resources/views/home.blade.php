@extends('layout') @section('content')

<section class="home-wrapper">
    <h2 class="text-header">Streamline Sales Database Workflow</h2>
    <p class="text-desc">
        Your all-in-one solution for managing insurance
        clients. Our platform features a comprehensive client database,
        intuitive sales graphs, and efficient tracking of case closures,
        policy renewals and claims. Optimize our workflow and enhance decision-making with
        our user-friendly interface, created to help our team stay organized and
        excel in the competitive insurance market.
    </p>

    <!-- Cards -->
    <div class="cards-wrapper">
        <div class="item-card animate-card" data-delay="0.2s">
            <div class="card-body">
                <h2 class="card-title">IPMI Dashboard</h2>
                <p class="card-text">
                    Dataloki provides valuable insights into sales and
                    commission trends, helping us make informed business
                    decisions.
                </p>
            </div>
        </div>
        <div class="item-card animate-card" data-delay="0.2s">
            <div class="card-body">
                <h2 class="card-title">Client Database</h2>
                <p class="card-text">
                    Dataloki allows us to easily manage our clients'
                    information in one place, including their policy details and
                    claims.
                </p>
            </div>
        </div>
        <div class="item-card animate-card" data-delay="0.2s">
            <div class="card-body">
                <h2 class="card-title">Case Closures & Renewals</h2>
                <p class="card-text">
                    Track case closures and policy renewals efficiently, keeping
                    our team organized and up-to-date.
                </p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-white mt">
        <section class="text-white mt-2 py-2">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="footer-text">
                        &copy; {{ date("Y") }}
                        <b style="color: #5046e5">Datalokey</b>. All rights
                        reserved.
                    </p>
                </div>
            </div>
        </section>
    </footer>
</section>

<!-- Script -->
<script>
    document.querySelectorAll('.animate-card').forEach((card, index) => {
        card.style.animationDelay = `${index * 0.3}s`;
    });
</script>

@endsection
