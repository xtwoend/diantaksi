<?php
// loop schedulemaster
      foreach (Schedulemaster::all() as $sm) { 

        echo $sm->name; 
      
        //Formasi ' . $sm->name . '<br>';
              // loop group
              	foreach (Schedulegroup::where_schedule_master_id($sm->id)->where_pool_id(Auth::user()->pool_id)->order_by('group')->get() as $grp) {
                  	
                  	echo 'Groups #';  echo $grp->group; echo '<br>';
                  	echo '<table class="table table-bordered table-striped table-condensed">';
		            echo '<thead>
							<tr><th>Body</th>
								<th>Driver</th>';
								for($i=1; $i <= $countmonth; $i++){
									echo '<th>' . $i . '</th>' ;
								}
					echo '</tr>
						</thead>';


		                $driver_ar = array();
		                  // loop fleet group
		                foreach (Schedulefleetgroup::where_schedule_group_id($grp->id)->get() as $scf) {
		                      //echo 'fleet id'; echo $scf->fleet_id; echo '<br>';
		                                       
		                      // loop  schedule
		                      $scdul = Schedule::where('fleet_id','=' , $scf->fleet_id)->where('pool_id', '=', Auth::user()->pool_id )->where('month', '=', date('n', $timestamp) )->where('year', '=', date('Y', $timestamp))->get();                           
		                    foreach ($scdul as $as) {
		                        
		                        // loop schedule date / driver
		                        $scheduledate = Scheduledate::where('schedule_id','=', $as->id)->group_by('driver_id')->get(array('driver_id'));
		                        foreach ($scheduledate as $gdriver) {
		                          
			                        if( ! in_array($gdriver->driver_id, $driver_ar) ){
			                            array_push($driver_ar, $gdriver->driver_id); 
			                        }
		                        }
		                    }   
		                }

		                  /********************************/
		                  /* Proses Pembuatan Jadwal View */
		                  /********************************/
		                if(is_array($driver_ar) && !empty($driver_ar))
		                {	
		                	
	                    	foreach ($driver_ar as $key => $value) {
		                      $a =  Scheduledate::join('schedules', 'schedules.id','=', 'schedule_dates.schedule_id')
		                          ->where('schedules.month', '=', date('n', $timestamp) )
		                          ->where('schedules.year', '=', date('Y', $timestamp) )
		                          ->where('pool_id', '=', Auth::user()->pool_id )
		                          ->where('schedule_dates.driver_id', '=', $value) 
		                          ->get();

		                          $free = array();
		                          // prosess pembentukan jadwal per pengemudi dalam group
		                          foreach ($a as $aa) {
		                              //echo 'Tanggal '. $aa->date .' di bawa pengemudi ' . $aa->driver_id ;
		                                
		                              //echo '<br>';
		                              array_push($free, $aa->date);
		                          }  
		                        // DISPLY PENGEMUDI
		                       	echo '<tr>';
			                	echo '<td>';
			                    //echo 'Driv ' . $value ;
			                    $kso = Kso::where_bravo_driver_id($value)->where_actived(1)->first();
			                    if($kso) echo Fleet::find($kso->fleet_id)->taxi_number;
			                    echo '</td>';
			                    echo '<td>';
		                       	echo Driver::find($value)->name;
		                       	echo '</td>';
			                        $holiday = array();
			                        for ($i=1; $i <= date('t', $timestamp); $i++) { 
			                               
			                               if(is_array($free) && !empty($free))
			                               {
				                                if (! in_array($i, $free)) {
				                                	echo '<td style="background-color: #fcf8e3">';
				                                	// Set Libur symbol
				                                	echo ' L ';
				                                    array_push($holiday, $i);
				                                }else{
				                                	echo '<td style="background-color: #dff0d8">';
				                                }

			                               }
			                               echo '</td>';
			                        } 
			                          //$hol = implode(", ", $holiday);
			                          //echo ' Pengemudi ' . $value . ' Libur Tanggal ' . $hol;
			                          //echo '<br>';
		                      	echo '</tr>'; 
	                    	} 
	                    	     
                  		}
                  	echo '</table>';	
              	}

              echo '</div></div>';
      }
?>