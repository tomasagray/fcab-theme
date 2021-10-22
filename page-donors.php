<?php

namespace fcab;

use JsonException;
use WP_Query;

const ORIGINAL_MEMBERS_PAGE = 'Original Members';
const DONATION_FIELD_NAME = 'fcab_donation_donation_amount';
const POST_TYPE = 'fcab_cpt_donor';


function partition_donors(array $_donors): array
{
    $donors = $_donors;
    $intervals = [500, 1000, 2000, 5000, 10000, PHP_INT_MAX];
    $donor_table = [];

    try {
        while (($donor = array_pop($donors)) !== null) {
            $metadata = get_post_meta($donor->ID, DONATION_FIELD_NAME, true);
            if ($metadata === '') {
                // skip if no donations
                continue;
            }
            $donations = json_decode($metadata, true, 16, JSON_THROW_ON_ERROR);
            $total_donations = get_total_donations($donations);
            if ($total_donations === 0) {
                // bail early
                continue;
            }
            foreach ($intervals as $interval) {
                if ($total_donations <= $interval) {
                    $donor_table[$interval][] = $donor;
                    break;
                }
            }
        }
    } catch (JsonException $e) { ?>
        <div class="error-message-wrapper">
            <p>
                <strong style="color: red">ERROR!</strong> There was a problem decoding donation data. The error
                was:<br/> <strong><?php echo $e->getMessage(); ?></strong>
            </p>
        </div>
        <?php
    }
    return $donor_table;
}

function get_total_donations(array $donations): int
{
    $total_donations = 0;
    foreach ($donations as $donation) {
        if (array_key_exists('amount', $donation)) {
            $total_donations += $donation['amount'];
        }
    }
    return $total_donations;
}

/**
 * @param $intervals
 * @param array $donor_groups
 * @param $donors
 */
function print_top_level_donors($intervals, array &$donor_groups, &$donors): void
{
    $top_floor = $intervals;
    if (count($donor_groups[$top_floor]) > 0) {
//        echo '<h3 class="donors-heading">$' . $top_floor . ' - above</h3>';
        $donors = array_pop($donor_groups);
        print_donors($donors);
    }
}

/**
 * @param $intervals
 * @param array $donor_groups
 */
function print_bottom_level_donors($intervals, array $donor_groups): void
{
    $bottom_group = $intervals;
    if (count($donor_groups[$bottom_group]) > 0) {
//        echo '<h3 class="donors-heading">Up to $' . $bottom_group . '</h3>';
        print_donors($donor_groups[$bottom_group]);
    }
}

/**
 * @param array $donors
 */
function print_donors(array $donors)
{
    echo '<div class="donor-box">';
    foreach ($donors as $donor):
        ?>
        <div class="donor-card">
            <?php
            $thumb_url = get_the_post_thumbnail_url($donor);
            if ($thumb_url !== false):
                ?>
                <div class="donor-image" style="background-image: url('<?php echo $thumb_url; ?>');"></div>
            <?php
            endif;
            ?>
            <div class="donor-summary">
                <p class="donor-title"><?php echo $donor->post_title; ?></p>
            </div>
        </div>
    <?php
    endforeach;
    echo '</div>';
}

function print_donor_table(array $donors): void
{
    $donor_groups = partition_donors($donors);
    ksort($donor_groups);
    $intervals = array_keys($donor_groups);
    $num_intervals = count($intervals) - 1;
    if ($num_intervals === 0) {
        print_bottom_level_donors($intervals[0], $donor_groups);
        return;
    }

    for ($i = $num_intervals; $i >= 0; $i--) {
        switch ($intervals[$i]) {
            case PHP_INT_MAX:
                print_top_level_donors($intervals[$num_intervals - 1], $donor_groups, $donors);
                break;
            case $intervals[0]:
                print_bottom_level_donors($intervals[0], $donor_groups);
                break;
            default:
                $top = $intervals[$i];
//                $bottom = $intervals[$i - 1];
                if (count($donor_groups[$top]) > 0) {
//                    echo '<h3 class="donors-heading">$' . $bottom . ' - $' . $top . '</h3>';
                    $top_donors = array_pop($donor_groups);
                    print_donors($top_donors);
                }
                break;
        }
    }
}

$q_args = [
    'post_type' => POST_TYPE,
    'post_status' => 'publish',
    'posts_per_page' => -1,
];
// Get donors
$loop = new WP_Query($q_args);

get_header();
?>
    <div class="content-box">
        <?php
        $members_page = get_page_by_title(ORIGINAL_MEMBERS_PAGE);
        $link = get_permalink($members_page->ID);
        ?>
        <div id="donors-container">
            <h1 style="display: inline;">Our Donors</h1>
            <a href="<?php echo $link; ?>" class="link-button"
               style="float: right;"><?php echo $members_page->post_title; ?></a>
            <?php
            $donors = $loop->get_posts();
            if (count($donors) > 0) {
                print_donor_table($donors);
            } else {
                echo "<p>No donors found.</p>";
            }
            ?>
        </div>
    </div>
    <?php
get_footer();
