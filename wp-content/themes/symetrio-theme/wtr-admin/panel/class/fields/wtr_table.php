<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR . '/fields/wtr_field.php' );

if ( ! class_exists( 'WTR_Table' ) ) {

	class WTR_Table extends WTR_Filed {

		public function draw( $name = NULL ){

			$name_field = ( $name ) ? ( $name . '['. $this->id . ']' ) : $this->id;
			$colsC		= count( $this->get( 'cols_attr' ) );
			$rowsC		= count( $this->get( 'rows_attr' ) );
			$cols_attr	= $this->get( 'cols_attr' );
			$rows_attr	= $this->get( 'rows_attr' );
			$cols		= $this->get( 'cols' );
			$rows		= $this->get( 'rows' );
			$option		= $this->get( 'option' );
			$option_sht	= $this->get( 'option_shortcode' );
			$opt_prev	= $this->get( 'option_prev' );
			$cellNo		= 0;
			$counter	= 0;
			?>
			<!-- Help stop -->
			<div class="helpInfo">
				<a class="helpInfoLink" href="#"><?php _e( 'Need help with tables?', 'wtr_framework' ); ?></a>
				<div class="helpInfoDesc">
					<?php echo $this->info ?>
					<span class="hideHelp"></span>
				</div>
			</div>
			<!-- Help stop -->
			<!-- Table Generator Start -->
			<div class="Wtr_Table_Form" id="<?php echo $this->id; ?>"
				data-min-col="<?php echo $cols[ 'min' ]; ?>"
				data-max-col="<?php echo $cols[ 'max' ]; ?>"
				data-min-row="<?php echo $rows[ 'min' ]; ?>"
				data-max-row="<?php echo $rows[ 'max' ]; ?>"
				data-add-row-default="<?php echo $this->get( 'rows_attr_default' ); ?>"
				data-add-col-default="<?php echo $this->get( 'cols_attr_default' ); ?>"
				>
				<div class="tableGeneratorContent unselectable">
					<!-- Table Generator Feature Nag Start -->
					<div class="tableRow tableRowFeature tableAttrSelects">
						<div class="tableCell tableCellFeature"></div>
						<?php
							for( $i = 0; $i < $colsC; ++$i ){ ?>
								<div class="tableCell tablCellAttr Wtr_Table_Col_Attr" data-id-col="<?php echo $i; ?>">
									<div class="selectdiv">
 										<select class="selectboxdiv TableSelectCol">
										<?php
											foreach( $this->get( 'cols_attr_option' ) as $val => $key ){?>
												<option <?php if(  $val == $cols_attr[ $i ] ) { echo 'selected="selected"'; } ?> value="<?php echo $val; ?>"><?php echo $key; ?></option>
											<?php }
										?>
										</select>
										<div class="out"></div>
									</div>
								</div>
							<?php } ?>
						<div class="tableCell tableCellBtnsCol tableCellBtnDel"></div>
					</div>
					<!-- Table Generator Feature Nag Stop -->

					<!-- Table Generator Default Row Start -->
					<?php for( $i = 0; $i < $rowsC; ++$i ) { ?>
						<div class="tableRow Wtr_Table_Row">
							<div class="tableCell tableCellFeature">
								<div class="selectdiv">
										<select class="selectboxdiv TableSelectRow">
										<?php
											foreach( $this->get( 'rows_attr_option' ) as $val => $key ){?>
												<option <?php if(  $val == $rows_attr[ $i ] ) echo 'selected="selected"'; ?> value="<?php echo $val; ?>"><?php echo $key; ?></option>
											<?php }
										?>
									</select>
									<div class="out"></div>
								</div>
							</div>
							<!-- generation of cells in the row -->
							<?php
							for( $j = 0; $j < $colsC; ++$j ){

								if( isset( $option[ $counter ] ) ){

									$flagCell = 'none';
									$typeCell = $option[ $counter ][ 'type_external' ][ 'value' ];
								}
								else{

									$flagCell = 'block';
									$typeCell = 'null';
								}
							?>
								<div class="tableCell tableCellEditable wtrTableCellEditable" data-id-row="<?php echo $i; ?>"   data-id-col="<?php echo $j; ?>" data-id-cell="<?php echo $cellNo++; ?>">
									<!-- call to action -->
									<div class="wtrTableEmptyCell" style="display:<?php echo $flagCell;?>">
										<div style="display:none;" class="tableCellAction"><?php _e( 'Click to fill field', 'wtr_framework' )  ?></div>
										</div>
									<!-- add new item -->
									<div style="display:none"  class="tableCellFillFeatures wtrTableFormAddNewItem">
										<div class="tableCellFillFeaturesCol">
											<div class="selectdiv">
												<select class="selectboxdiv">
													<?php foreach( $this->get( 'modal_child_size' ) as $key => $val ){ ?>
														<option value="<?php echo $key;?>" data-width="<?php echo $val[ 'width' ];?>" data-height="<?php echo $val[ 'height' ];?>" data-fullscreenw="<?php echo $val[ 'fullscreenw' ];?>" data-fullscreenh="<?php echo $val[ 'fullscreenh' ];?>"  data-main-class="<?php echo $val[ 'mian_class' ];?>" ><?php echo $val[ 'title' ]; ?></option>
													<?php } ?>
												</select>
												<div class="out"></div>
											</div>
										</div>
										<div class="tableCellFillFeaturesCol tableCellFillFeaturesColBtn">
											<a href="" class="WonButton blue wtr_table_cell_filled"><?php _e( 'Add', 'wtr_framework' ) ?></a>
										</div>
										<div class="clear"></div>
									</div>
									<!-- graphic item -->
									<?php
										if( isset( $option[ $counter ][ 'type_external' ][ 'value' ] ) ){

											$temp_prev	= $opt_prev[ $option[ $counter ][ 'type_external' ][ 'value' ] ];
											$prevtmp	= trim( strip_tags( $option[ $counter ][ $temp_prev ][ 'value' ] ) );

											if( strlen( $prevtmp ) >= 350 ){
												$prevTableText = mb_substr( $prevtmp, 0, 350 ) . '...';
											} else {
												$prevTableText = $prevtmp;
											}

											switch( $option[ $counter ][ 'type_external' ][ 'value' ] ){
												case 'WTR_Shortcode_Paragraph': ?>
													<div style="display:block" data-type-elem="WTR_Shortcode_Paragraph" class="obiectPreview wtrTablePrevP Table_Item_Elem">
														<div class="paragraphPreview">
														<span class="wtrTableItemPrev"><?php echo $prevTableText; ?></span>
														<div class="obiectPreviewDelete wtrobiectPreviewDelete"></div>
														<input type="hidden" class="wtrTableItemValue" value="<?php echo $option_sht[ $counter ] ?>"/>
														</div>
													</div>
												<?php
												break;

												case 'WTR_Shortcode_Button':
												?>
													<div style="display:block" data-type-elem="WTR_Shortcode_Button" class="obiectPreview wtrTablePrevBtn Table_Item_Elem">
														<div class="buttonPreview">
															<div class="buttonPreviewItem wtrTableItemPrev"><?php echo $prevTableText;  ?></div>
															<div class="obiectPreviewDelete wtrobiectPreviewDelete"></div>
															<input type="hidden" class="wtrTableItemValue" value="<?php echo $option_sht[ $counter ] ?>"/>
														</div>
													</div>
												<?php
												break;
											}
										}
									?>
								</div>
							<?php $counter++; } ?>
							<!-- end generation of cells in the row -->
							<div class="tableCell tableCellBtnsCol">
								<span class="deleteItem Wtr_Table_Delete_Row" data-id-row="<?php echo $i; ?>"></span>
							</div>
						</div>
					<!-- Table Generator Default Row Stop -->
					<?php } ?>
					<!-- Table Generator Last Feature foot Start -->
					<div class="tableRow tableRowFeature TableRowDel last">
						<div class="tableCell tableCellFeature "></div>
						<?php
							for( $i = 0; $i < $colsC; ++$i ){ ?>
								<div class="tableCell tableCellBtns Wtr_Table_Col_Del_Contener">
									<span class="deleteItem Wtr_Table_Delete_Col" data-id-col="<?php echo $i; ?>"></span>
								</div>
							<?php } ?>
					</div>
					<!-- Table Generator Last Feature foot Stop -->
				</div>
				<input type="hidden" name="<?php echo $name_field; ?>" class ="<?php echo $this->class ?>" value=""/>
			</div>
		<?php }// draw


		public function exportSettings(){

			return array(
						'cols'				=> $this->get( 'cols' ),
						'cols_attr'			=> $this->get( 'cols_attr' ),
						'cols_attr_option'	=> $this->get( 'cols_attr_option' ),
						'rows'				=> $this->get( 'rows' ),
						'rows_attr'			=> $this->get( 'rows_attr' ),
						'rows_attr_option'	=> $this->get( 'rows_attr_option' ),
						'option'			=> $this->get( 'option_item' ),
						'option_shortcode'	=> $this->get( 'option_shortcode' ),
						'option_prev'		=> $this->get( 'option_prev' ),
						'draw_option'		=> $this->get( 'draw_option' ),
						'defautl_rewrite'	=> $this->get( 'defautl_rewrite' ),
						'child_shortcode'	=> $this->get( 'child_shortcode' ),
						'child_end_el'		=> $this->get( 'child_end_el' )
					);
		}// end exportSettings
	};// end WTR_Table
}