<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <button class="btn btn-sm btn-outline-secondary">Share</button>
                <button class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar"></span>
                This week
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3" id="external-events">
            <p><strong>Rooms</strong></p>
            <?php foreach ($room->result() as $r) : ?>
                <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event">
                    <div class="fc-event-main"><?= $r->r_name; ?></div>
                </div>
            <?php endforeach; ?>
            <div class="mt-3">
                <p><strong>Details</strong></p>
                <table>
                    <tr>
                        <td>Name:</td>
                        <td>room4</td>
                    </tr>
                    <tr>
                        <td>customer:</td>
                        <td>ANDRIANILANA</td>
                    </tr>
                    <tr>
                        <td>Check-in date:</td>
                        <td>Today</td>
                    </tr>
                    <tr>
                        <td>Check-out date:</td>
                        <td>Tomorrow</td>
                    </tr>
                </table>

            </div>

        </div>
        <div class="col-md-9" id="calendar">

        </div>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var containerEl = document.getElementById('external-events');

            var Draggable = new FullCalendar.Draggable(containerEl, {
                itemSelector: '.fc-event',
                eventData: function(eventEl) {
                    return {
                        title: eventEl.innerText

                    };

                }
            });

            var Calendar = new FullCalendar.Calendar(calendarEl, {
                height: 500,
                width: 500,
                themeSystem: 'bootstrap',
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                editable: true,
                droppable: true
            });
            Calendar.render();


        });
    </script>

</main>
</div>
</div>