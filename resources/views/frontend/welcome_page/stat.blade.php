<section id="stats" class="py-5 bg-light">
    <link rel="stylesheet" href="{{ asset('css/custom_stat.css') }}">
    <div class="container">
        <div class="row text-center g-4">

            <div class="col-md-3 col-6">
                <div class="stat-box">
                    <div class="stat-icon-wrap">
                        <i class="bi bi-emoji-smile"></i>
                    </div>
                    <h2 class="stat-number" data-target="1800">0</h2>
                    <p class="stat-label">Happy Patients</p>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="stat-box">
                    <div class="stat-icon-wrap">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <h2 class="stat-number" data-target="5">0</h2>
                    <p class="stat-label">Qualified Doctors</p>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="stat-box">
                    <div class="stat-icon-wrap">
                        <i class="bi bi-hospital"></i>
                    </div>
                    <h2 class="stat-number" data-target="1500">0</h2>
                    <p class="stat-label">Major Operations</p>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="stat-box">
                    <div class="stat-icon-wrap">
                        <i class="bi bi-people"></i>
                    </div>
                    <h2 class="stat-number" data-target="0">0</h2>
                    <p class="stat-label">Local Partners</p>
                </div>
            </div>

        </div>
    </div>

    <script>
        const counters = document.querySelectorAll('.stat-number');
        let started = false;

        function startCounting() {
            if (started) return;

            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                let count = 0;
                const speed = 200;

                const updateCount = () => {
                    const increment = Math.ceil(target / speed);
                    count += increment;

                    if (count < target) {
                        counter.innerText = count;
                        requestAnimationFrame(updateCount);
                    } else {
                        counter.innerText = target;
                    }
                };

                updateCount();
            });

            started = true;
        }

        window.addEventListener('scroll', () => {
            const section = document.getElementById('stats');
            const sectionTop = section.getBoundingClientRect().top;

            if (sectionTop < window.innerHeight - 100) {
                startCounting();
            }
        });
    </script>
</section>
