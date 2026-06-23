<?php
/**
 * Reservation Section
 */

// Helper to get fallback hours (avoid code duplication)
function obirc_reservation_fallback_hours() {
    return array(
        array( 'day' => 'Monday – Thursday', 'time' => '5 PM – 10 PM' ),
        array( 'day' => 'Friday', 'time' => '5 PM – 11 PM' ),
        array( 'day' => 'Saturday', 'time' => '12 PM – 11 PM' ),
        array( 'day' => 'Sunday', 'time' => '12 PM – 9 PM' ),
    );
}

$hours = array();
$note  = '';
$title = '';

// If plugin is active, try to get dynamic data
if ( defined( 'OBIRC_VERSION' ) ) {
    $hours_posts = get_posts( array(
        'post_type'      => 'obirc_opening_hours',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
    ) );

    if ( ! empty( $hours_posts ) ) {
        $hours_id = $hours_posts[0]->ID;
        $hours_raw = get_post_meta( $hours_id, 'obirc_opening_hours', true );
        if ( is_array( $hours_raw ) && ! empty( $hours_raw ) ) {
            $hours = $hours_raw;
        }
        $note  = get_post_meta( $hours_id, 'obirc_opening_hours_note', true );
        $note  = $note ?: '';
        $title = get_the_title( $hours_id );
    }
}

// Fallback if no dynamic data
if ( empty( $hours ) ) {
    $hours = obirc_reservation_fallback_hours();
}
if ( empty( $title ) ) {
    $title = __( 'Opening Hours', 'obydullah-restaurant' );
}
if ( empty( $note ) ) {
    $note = __( 'Last reservation 30 minutes before closing', 'obydullah-restaurant' );
}
?>
<section class="reservation" id="reservation">
    <div class="reservation__container">
        <div class="reservation__grid">
            <!-- Left: Opening Hours -->
            <div class="reservation__hours hours-panel">
                <div class="hours-panel__icon">
                    <i class="fa-regular fa-clock"></i>
                </div>
                <h3 class="hours-panel__title"><?php echo esc_html( $title ); ?></h3>
                <ul class="hours-panel__list">
                    <?php foreach ( $hours as $item ) : ?>
                    <li class="hours-panel__item">
                        <span class="hours-panel__day"><?php echo esc_html( $item['day'] ); ?></span>
                        <span class="hours-panel__time"><?php echo esc_html( $item['time'] ); ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <p class="hours-panel__note"><?php echo esc_html( $note ); ?></p>
            </div>

            <!-- Right: Booking Form -->
            <div class="reservation__form booking-panel">
                <form class="booking-form" id="bookingForm" novalidate>
                    <div class="booking-form__group">
                        <label for="bookingName">Full Name <span class="required-star">*</span></label>
                        <input type="text" id="bookingName" name="name" placeholder="John Doe" required
                            autocomplete="name" />
                    </div>
                    <div class="booking-form__group">
                        <label for="bookingEmail">Email Address <span class="required-star">*</span></label>
                        <input type="email" id="bookingEmail" name="email" placeholder="john@example.com" required
                            autocomplete="email" />
                    </div>
                    <div class="booking-form__group">
                        <label for="bookingPhone">Phone Number <span class="required-star">*</span></label>
                        <input type="tel" id="bookingPhone" name="phone" placeholder="+1 (555) 000-0000" required
                            autocomplete="tel" />
                    </div>
                    <div class="booking-form__group">
                        <label for="bookingParty">Party Size <span class="required-star">*</span></label>
                        <select id="bookingParty" name="party" required>
                            <option value="" disabled selected>Select guests</option>
                            <option value="1">1 Guest</option>
                            <option value="2">2 Guests</option>
                            <option value="3">3 Guests</option>
                            <option value="4">4 Guests</option>
                            <option value="5">5 Guests</option>
                            <option value="6">6 Guests</option>
                            <option value="7">7 Guests</option>
                            <option value="8">8+ Guests</option>
                        </select>
                    </div>
                    <div class="booking-form__group">
                        <label for="bookingDate">Date <span class="required-star">*</span></label>
                        <input type="date" id="bookingDate" name="date" required
                            min="<?php echo esc_attr( date('Y-m-d') ); ?>" />
                    </div>
                    <div class="booking-form__group">
                        <label for="bookingTime">Time <span class="required-star">*</span></label>
                        <select id="bookingTime" name="time" required>
                            <option value="" disabled selected>Select time</option>
                            <option value="17:00">5:00 PM</option>
                            <option value="17:30">5:30 PM</option>
                            <option value="18:00">6:00 PM</option>
                            <option value="18:30">6:30 PM</option>
                            <option value="19:00">7:00 PM</option>
                            <option value="19:30">7:30 PM</option>
                            <option value="20:00">8:00 PM</option>
                            <option value="20:30">8:30 PM</option>
                            <option value="21:00">9:00 PM</option>
                        </select>
                    </div>
                    <div class="booking-form__group booking-form__group--full">
                        <label for="bookingNotes">Special Requests</label>
                        <textarea id="bookingNotes" name="notes"
                            placeholder="Allergies, dietary needs, special occasions..." spellcheck="false"></textarea>
                    </div>
                    <button type="submit" class="btn btn--primary booking-form__submit">
                        Confirm Reservation
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>