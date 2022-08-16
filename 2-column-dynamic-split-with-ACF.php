<?php
/**
 * FAQ Section Template Part
 */

$faq_title        = get_field( 'faq_title' );
$faq_items        = get_field( 'faq_items' );

// Get the number of list items, the middle index and the last index.
$faq_items_length = count( $faq_items );
$last_index = $faq_items_length - 1;
$middle_index = floor( $last_index / 2 );

// Separate the two lists if more than 1 item, otherwise set the one item to the first column.
if ( 2 <= $faq_items_length ) {
	$faq_column_one = array_slice( $faq_items, 0, $middle_index + 1 );
	$faq_column_two = array_slice( $faq_items, $middle_index + 1 );
}
else {
	$faq_column_one = $faq_items;
}
?>

<div class="faq">

	<?php if ( $faq_title ) : ?>
		<div class="faq-title">
			<h2><?php echo esc_html( $faq_title ); ?></h2> 
		</div><!-- .faq-title -->
	<?php endif; ?>
	
	<?php if ( $faq_items ) : ?>
		<div class="faq-content">
			
			<?php if ( $faq_column_one ) : ?>
			<div class="faq-column">
				<?php foreach ($faq_column_one as $faq_item) : ?>
					<details>
						<?php if ( $question = $faq_item[ 'question' ] ) : ?>
							<summary><?php echo esc_html( $question ); ?></summary>
						<?php endif; ?>

						<?php if ( $answer = $faq_item[ 'answer' ] ) : ?>
							<?php echo wp_kses_post( $answer ); ?>
						<?php endif; ?>
					</details>
				<?php endforeach; ?>
			</div><!-- .faq-column -->
			<?php endif; ?>

			<?php if ( $faq_column_two ) : ?>
			<div class="faq-column">
				<?php foreach ($faq_column_two as $faq_item) : ?>
					<details>
						<?php if ( $question = $faq_item[ 'question' ] ) : ?>
							<summary><?php echo esc_html( $question ); ?></summary>
						<?php endif; ?>

						<?php if ( $answer = $faq_item[ 'answer' ] ) : ?>
							<?php echo wp_kses_post( $answer ); ?>
						<?php endif; ?>
					</details>
				<?php endforeach; ?>
			</div><!-- .faq-column -->
			<?php endif; ?>

		</div><!-- .faq-content -->
	<?php endif; ?>
</div><!-- .faq -->
