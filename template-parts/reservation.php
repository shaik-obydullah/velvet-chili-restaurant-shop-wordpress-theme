<?php
/**
 * Reservation Section
 * - Opening hours from 'obirsc_opening_hours' CPT (single post)
 * - Note from meta
 * - Static fallback when plugin inactive or no data
 */

function vcrs_reservation_fallback_hours() {
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

if ( defined( 'OBIRSC_VERSION' ) ) {
    $hours_posts = get_posts( array(
        'post_type'      => 'obirsc_opening_hours',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
    ) );

    if ( ! empty( $hours_posts ) ) {
        $hours_id   = $hours_posts[0]->ID;
        $hours_raw  = get_post_meta( $hours_id, 'obirsc_opening_hours', true );
        $note       = get_post_meta( $hours_id, 'obirsc_opening_hours_note', true );
        $title      = get_the_title( $hours_id );

        if ( is_array( $hours_raw ) && ! empty( $hours_raw ) ) {
            $hours = $hours_raw;
        }
    }
}

// Fallback if no dynamic data
if ( empty( $hours ) ) {
    $hours = vcrs_reservation_fallback_hours();
}
if ( empty( $title ) ) {
    $title = __( 'Opening Hours', 'velvet-chili-restaurant-shop' );
}
if ( empty( $note ) ) {
    $note = __( 'Last reservation 30 minutes before closing', 'velvet-chili-restaurant-shop' );
}

// Nonce for booking form (matches plugin's 'obirsc_booking_nonce')
$booking_nonce = wp_create_nonce( 'obirsc_booking_nonce' );
?>

<section class="reservation" id="book">
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
                    <!-- Nonce field (required by plugin) -->
                    <input type="hidden" name="nonce" value="<?php echo esc_attr( $booking_nonce ); ?>">

                    <div class="booking-form__group">
                        <label for="bookingName"><?php esc_html_e( 'Full Name', 'velvet-chili-restaurant-shop' ); ?>
                            <span class="required-star">*</span></label>
                        <input type="text" id="bookingName" name="name"
                            placeholder="<?php esc_attr_e( 'John Doe', 'velvet-chili-restaurant-shop' ); ?>" required
                            autocomplete="name" />
                    </div>
                    <div class="booking-form__group">
                        <label
                            for="bookingEmail"><?php esc_html_e( 'Email Address', 'velvet-chili-restaurant-shop' ); ?>
                            <span class="required-star">*</span></label>
                        <input type="email" id="bookingEmail" name="email"
                            placeholder="<?php esc_attr_e( 'john@example.com', 'velvet-chili-restaurant-shop' ); ?>"
                            required autocomplete="email" />
                    </div>
                    <div class="booking-form__group">
                        <label for="bookingPhone"><?php esc_html_e( 'Phone Number', 'velvet-chili-restaurant-shop' ); ?>
                            <span class="required-star">*</span></label>
                        <input type="tel" id="bookingPhone" name="phone"
                            placeholder="<?php esc_attr_e( '+1 (555) 000-0000', 'velvet-chili-restaurant-shop' ); ?>"
                            required autocomplete="tel" />
                    </div>
                    <div class="booking-form__group">
                        <label for="bookingParty"><?php esc_html_e( 'Party Size', 'velvet-chili-restaurant-shop' ); ?>
                            <span class="required-star">*</span></label>
                        <select id="bookingParty" name="party" required>
                            <option value="" disabled selected>
                                <?php esc_html_e( 'Select guests', 'velvet-chili-restaurant-shop' ); ?></option>
                            <option value="1"><?php esc_html_e( '1 Guest', 'velvet-chili-restaurant-shop' ); ?></option>
                            <option value="2"><?php esc_html_e( '2 Guests', 'velvet-chili-restaurant-shop' ); ?>
                            </option>
                            <option value="3"><?php esc_html_e( '3 Guests', 'velvet-chili-restaurant-shop' ); ?>
                            </option>
                            <option value="4"><?php esc_html_e( '4 Guests', 'velvet-chili-restaurant-shop' ); ?>
                            </option>
                            <option value="5"><?php esc_html_e( '5 Guests', 'velvet-chili-restaurant-shop' ); ?>
                            </option>
                            <option value="6"><?php esc_html_e( '6 Guests', 'velvet-chili-restaurant-shop' ); ?>
                            </option>
                            <option value="7"><?php esc_html_e( '7 Guests', 'velvet-chili-restaurant-shop' ); ?>
                            </option>
                            <option value="8"><?php esc_html_e( '8+ Guests', 'velvet-chili-restaurant-shop' ); ?>
                            </option>
                        </select>
                    </div>
                    <div class="booking-form__group">
                        <label for="bookingDate"><?php esc_html_e( 'Date', 'velvet-chili-restaurant-shop' ); ?> <span
                                class="required-star">*</span></label>
                        <input type="date" id="bookingDate" name="date" required
                            min="<?php echo esc_attr( date( 'Y-m-d' ) ); ?>" />
                    </div>
                    <div class="booking-form__group">
                        <label for="bookingTime"><?php esc_html_e( 'Time', 'velvet-chili-restaurant-shop' ); ?> <span
                                class="required-star">*</span></label>
                        <select id="bookingTime" name="time" required>
                            <option value="" disabled selected>
                                <?php esc_html_e( 'Select time', 'velvet-chili-restaurant-shop' ); ?></option>
                            <option value="17:00"><?php esc_html_e( '5:00 PM', 'velvet-chili-restaurant-shop' ); ?>
                            </option>
                            <option value="17:30"><?php esc_html_e( '5:30 PM', 'velvet-chili-restaurant-shop' ); ?>
                            </option>
                            <option value="18:00"><?php esc_html_e( '6:00 PM', 'velvet-chili-restaurant-shop' ); ?>
                            </option>
                            <option value="18:30"><?php esc_html_e( '6:30 PM', 'velvet-chili-restaurant-shop' ); ?>
                            </option>
                            <option value="19:00"><?php esc_html_e( '7:00 PM', 'velvet-chili-restaurant-shop' ); ?>
                            </option>
                            <option value="19:30"><?php esc_html_e( '7:30 PM', 'velvet-chili-restaurant-shop' ); ?>
                            </option>
                            <option value="20:00"><?php esc_html_e( '8:00 PM', 'velvet-chili-restaurant-shop' ); ?>
                            </option>
                            <option value="20:30"><?php esc_html_e( '8:30 PM', 'velvet-chili-restaurant-shop' ); ?>
                            </option>
                            <option value="21:00"><?php esc_html_e( '9:00 PM', 'velvet-chili-restaurant-shop' ); ?>
                            </option>
                        </select>
                    </div>
                    <div class="booking-form__group booking-form__group--full">
                        <label
                            for="bookingNotes"><?php esc_html_e( 'Special Requests', 'velvet-chili-restaurant-shop' ); ?></label>
                        <textarea id="bookingNotes" name="notes"
                            placeholder="<?php esc_attr_e( 'Allergies, dietary needs, special occasions...', 'velvet-chili-restaurant-shop' ); ?>"
                            spellcheck="false"></textarea>
                    </div>

                    <!-- Message container for AJAX response -->
                    <div id="bookingMessage" class="booking-form__message" style="display:none;"></div>

                    <button type="submit" class="btn btn--primary booking-form__submit">
                        <?php esc_html_e( 'Confirm Reservation', 'velvet-chili-restaurant-shop' ); ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>