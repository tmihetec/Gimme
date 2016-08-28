
$(document).ready(function() {

	// http://stackoverflow.com/questions/10193294/how-can-i-tell-if-a-browser-supports-input-type-date
	function checkDateInputSupport() {
	    var input = document.createElement('input');
	    input.setAttribute('type','date');

	    var notADateValue = 'not-a-date';
	    input.setAttribute('value', notADateValue); 

	    return (input.value !== notADateValue);
	}


	// date string
	var datum = new Date(),
		d = datum.getDate(),
		m = datum.getMonth()+1,
		y = datum.getFullYear(),
		dateString;
	if(d<10) { d="0"+d;}
	if(m<10) { m="0"+m;}

	if (checkDateInputSupport()) {
		dateString = y+"-"+m+"-"+d;
	} else {
		dateString = d+"."+m+"."+y;
	}




	//https://datatables.net/blog/2014-12-18


	$.fn.dataTable.moment( 'DD.MM.YYYY' );
	$.fn.dataTable.moment( 'DD.MM.YYYY HH:mm' );

	$.extend( true, $.fn.dataTable.defaults, {
	    responsive: true,
		retrieve: true,
	    order: 	[
	    			[ 3, "desc" ]
	    		],
		columnDefs: [ 
				{
					"targets": -1,
					"orderable": false
				} 
					],
		lengthMenu: [
				[25, 50, 100, -1], 
				[25, 50, 100, "All"]
				],
		pageLength: 25,				
		fixedHeader: {
				headerOffset: 50
		}
	} );

    $('.datatable').DataTable({
    });

    $('.overviewtable').DataTable({
    	order: 	[
	    			[ 6, "desc" ]
	    		],
		columnDefs: [ 
				{
					"targets": -1,
					"orderable": true
				} 
				]
    });

    $('.datatableIndex').DataTable({
		lengthMenu: [
				[5, 10, 50, -1], 
				[5, 10, 50, "All"]
				],
		pageLength: 5,				
    	"columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        }
         ],
        pagingType: "simple",
        "order": [[ 3, 'desc' ]],
    }).on( 'order.dt search.dt', function (e, dt, type, indexes) {
        dt.oInstance.api().column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();


    $('.msgstable').DataTable({
		lengthMenu: [
				[10, 50, -1], 
				[10, 50, "All"]
				],
		pageLength: 10,				
        pagingType: "simple",
        "order": [[ 2, 'desc' ]],
    });

    $('.adminDashDT').DataTable({
		lengthMenu: [
				[10, 50, -1], 
				[10, 50, "All"]
				],
		pageLength: 10,				
    	"columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        }
         ],
		fixedHeader: false,
        "order": [[ 3, 'desc' ]],
    }).on( 'order.dt search.dt', function (e, dt, type, indexes) {
        dt.oInstance.api().column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    $('.adminDashDT2').DataTable({
		lengthMenu: [
				[10, 50, -1], 
				[10, 50, "All"]
				],
		pageLength: 10,				
    	"columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        }
         ],
		fixedHeader: false,
        "order": [[ 4, 'desc' ]],
    }).on( 'order.dt search.dt', function (e, dt, type, indexes) {
        dt.oInstance.api().column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();



    $(".itemstable").DataTable({
    	order: 	[
	    			[ 1, "asc" ]
	    		],
    });

    $(".realisationtable").DataTable({
    	//footer callback
    	//https://datatables.net/examples/advanced_init/footer_callback.html
    	order: 	[
	    			[ 3, "desc" ]
	    		],
    	"footerCallback": function( row, data, start, end, display ) {
    	
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 5 ).footer() ).html(
                pageTotal +' ('+ total +' total)'
            );

        }

    });


    $(".usersTable").DataTable({
    	//footer callback
    	//https://datatables.net/examples/advanced_init/footer_callback.html
    	order: 	[
	    			[ 8, "desc" ]
	    		],

    	"footerCallback": function( row, data, start, end, display ) {
    	
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {

				if (typeof i === 'string') {
			        (typeof $(i).html() == 'string') ?  
						r= $(i).html()
						:
						r= i;

				} else r=i;

				return parseInt(r);       	
            };
 
            // Total M over all pages
            totalM = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                	console.log(intVal(a));
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total M over this page
            pageTotalM = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );


            // Update footer M
			$( api.column( 8 ).footer() ).html(
                pageTotalM +'<span class="hidden-xs">/'+ totalM +'</span>');
 

            // Total Q over all pages
            totalQ = api
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total Q over this page
            pageTotalQ = api
                .column( 9, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 

            // Update footer Q
			$( api.column( 9 ).footer() ).html(
                pageTotalQ +'<span class="hidden-xs">/'+ totalQ +'</span>');


            // Total C over all pages
            totalC = api
                .column( 10 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total C over this page
            pageTotalC = api
                .column( 10, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer C
			$( api.column( 10 ).footer() ).html(
                pageTotalC +'<span class="hidden-xs">/'+ totalC +'</span>');

        }

    });


	// AJAX LOADING INDICATOR
	$(document).ajaxSend(function(event, request, settings) {
		$('#loading-indicator').show();
	});

	$(document).ajaxComplete(function(event, request, settings) {
		$('#loading-indicator').hide();
	});


	$(".postAction").on("click", function(){
		var that=$(this);
		url=that.data("myhref");
		token=that.data("token");
		$('<form method="post" action="'+url+'"><input type="hidden" name="_token" value="'+token+'" /></form>').appendTo('body').submit();
	});

	$(".deleteItem").on("click", function(){
		var that=$(this);
		bootbox.confirm("Are you sure?", function(result){
			if (result)
			{
				url=that.data("myhref");
				token=that.data("token");
				$('<form method="post" action="'+url+'"><input type="hidden" name="_method" value="delete"/><input type="hidden" name="_token" value="'+token+'" /></form>').appendTo('body').submit();
			}
		});
	});

	//potvrdi brisanje entrija realizacijskog
	$(".deleteRealisationItem").on("click",function(){
		var that=$(this);
		bootbox.confirm("Are you sure?", function(result){
		  if (result)
		  {
		  	id = that.data("id");
		  	token = that.data("delete");
		  	$.ajax({
		  		type: "delete",
		  		url: "/deleterealisationitem/"+id,
		  		data: {
		  			"_token": token
		  		},
		  		success: function(data) {
				    	 	// log data to the console so we can see
				    	 	//console.log(data);
				    	 	
				    	 	//obriši ak ima kaj od prije
				    	 	$("#messages div").hide();

				    	 	if (data.success) {
					    	 	//napravi novi div za obavijest
				    	 		mojdiv=$("#messages").prepend("<div class='alert alert-info'>"+data.message+"</div>");

				    	 		//makni red u tablici
				    	 		//var table = $('#example').DataTable(); 
							    $("#realisationTable").DataTable()
							        .row( that.parents('tr') )
							        .remove()
							        .draw();

					    	 	//counter na nove vrijednosti!
					    	 	if (data.deleted) {
						    	 	izvrtiCountere(data.newm, data.newq, data.newc);
						    	}
							} else { // error
					    	 	//napravi novi div za obavijest
				    	 		mojdiv=$("#messages").prepend("<div class='alert alert-danger'>"+data.message+"</div>");

							}

				    	 	//odskrolaj gore
				    	 	$('html, body').stop().animate({
							    scrollTop: $("#messages").offset().top-80
							}, 200 );

	 	 				},	
	 	 		error: function(jqXhr){
	 	 			alert("error"+jqXhr.status);
	 	 		}
		  	});
		  } 
		}); 

	});


	//izvrti countere
	function izvrtiCountere(m,q,c){
						    	 	// izvrti countere
							$('.scoreM').countTo({
							            from: parseInt($('.scoreM').text().replace(".","")),
							            to: parseInt(m),
							            speed: 200,
							            refreshInterval: 50,
							            onComplete: function(value) {
							                //console.debug(this);
							            }
							        });
							$('.scoreQ').countTo({
							            from: parseInt($('.scoreQ').text().replace(".","")),
							            to: parseInt(q),
							            speed: 400,
							            refreshInterval: 50,
							            onComplete: function(value) {
							                //console.debug(this);
							            }
							        });
							$('.scoreC').countTo({
							            from: parseInt($('.scoreC').text().replace(".","")),
							            to: parseInt(c),
							            speed: 600,
							            refreshInterval: 50,
							            onComplete: function(value) {
							                //console.debug(this);
							            }
							        });

 	}







	// Set the "bootstrap" theme as the default theme for all Select2
	// widgets.
	// @see https://github.com/select2/select2/issues/2927
	$.fn.select2.defaults.set( "theme", "bootstrap" );

    $("#realisationselect").select2({

      placeholder: "Select item",
      allowClear: true,
	  matcher: tmkSelect2MatchAnyKw,
	  templateResult: formatItems,
	  templateSelection: selectedItemTemplate,
	  width: null,
	  //containerCssClass: ':all:'
    }).on('select2:unselecting', function (evt) {
  		// Do something
  		$("#realisation-pt-box").html("");

	});

    $(".makethemselect2").select2({
    	placeholder: "Select...",
      	allowClear: true,
      	matcher: tmkSelect2MatchAnyKw,
      	width: null
    })

    // SAVE RELISATION
    $("#realisationsubmit").prop('disabled',true).on("click", function(){

    	var date = null,
    		invoice = null;
    	
    	// traži unos datuma i računa?
    	if(true) // u setup?
    	{

			bootbox.dialog({
			                title: "Pls fill in date and invoice number.",
			                message: '<div class="row">  ' +
			                    '<div class="col-md-12"> ' +
			                    '<form class="form-horizontal" method="post"> ' +
			                    
			                    '<div class="form-group"> ' +
			                    '<label class="col-md-4 control-label" for="invoiceno">Invoice no.</label> ' +
			                    '<div class="col-md-6"> ' +
			                    '<input id="mod_invoiceno" name="invoiceno" type="text" placeholder="Invoice no" class="form-control input-md" required> ' +
			                    '<span class="help-block">invoice number <span class="error"></span></span>  </div> ' +
			                    '</div> ' +

			                    '<div class="form-group"> ' +
			                    '<label class="col-md-4 control-label" for="date">Date</label> ' +
			                    '<div class="col-md-6"> ' +
			                    '<input id="mod_date" name="date" type="date" placeholder="Date" class="form-control input-md" value="'+dateString+'" required > ' +
			                    '<span class="help-block">invoice date (dd.mm.yyyy.)  <span class="error"></span></span> </div> ' +
			                    '</div> ' +

			                    '</form> </div>  </div>',
			                buttons: {
			                	cancel:{
			                		label: "Cancel"
			                	},
			                    success: {
			                        label: "Add to my score",
			                        className: "btn-success",
			                        callback: function () {
			                        	missing=requiredFields(['mod_date', 'mod_invoiceno']);
			                        	if (missing.length){
			                        		for(i=0; i<missing.length;i++)
			                        		{
			                        			$("#"+missing[i]).parent().find(".error").html(" - required").css("color","#f00");
			                        		}
		                        			return false;
			                        	} else {
										 	 // make ajax call - add2myscore
										   	add2myscore( $("#mod_date").val(), $("#mod_invoiceno").val() );
				                        	return;
			                        	}
			                        }
			                    }
			                }
			            }
			        );

    	} else {

	    	// make ajax call - add2myscore
	    	add2myscore(date, invoice);

    	}

	});

    requiredFields = function(fields){
    	missing=[];
    	for(i=0; i<fields.length; i++){
    		if ($("#"+fields[i]).val()=="") {
    			missing.push(fields[i]);
    		}
    	}
    	return missing;
    }

    // make ajax call to add score to user
    add2myscore = function(date, invoice){
    	    	// ajax call
    	$.ajax({
    		type 	: 	'post',
    		data 	: 	{
							"_token"	: $("#apptoken").val(),
							"points"	: $("#realisation-pt-box").data("points"),
							"user"		: $("#currentuser").val(),
							"itemid"	: $("#realisationselect").val(),
							"date"		: date,
							"invoice"	: invoice
			    		},
			dataType: 'json',
    		url 	: 	'/addscore',
			error: function(jqXhr){
					if( jqXhr.status === 422 ) {
							        //process validation errors here.
							        errors = jqXhr.responseJSON; //this will get the errors response data.
							        //console.log(errors);
							        /*
							        //show them somewhere in the markup
							        errorsHtml = '<ul class="myAjaxAlert list-unstyled alert alert-danger" role="alert">';
							        $.each( errors, function( key, value ) {
							            errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
							        });
							        errorsHtml += '</ul>';

							        // makni sve prethodne    
							        $('.myAjaxAlert').remove();

							        // ubaci ispred H1
							        $('h1').first().before( errorsHtml ); //appending to a <div id="form-errors"></div> inside form

							        // disable savebutton
							        $("#savebutton").prop("disabled",true).blur();

							        // skroll gore da se vide greške
							        //window.scrollTo(0,0);
							        //jQuery('html,body').animate({scrollTop:0},500);
							        */
							    }
							},
				success: function(data) {
				    	 	// log data to the console so we can see
				    	 	//console.log(data);


				    	 	// očisti select2
				    	 	$("#realisationselect").val(null).trigger("change");  		
				    	 	$("#realisation-pt-box").contents().wrap('<div class="temporary">').parent().fadeOut('fast');


				    	 	// izvrti countere
				    	 	izvrtiCountere(data.newm, data.newq, data.newc);


					        /*
					        
					        //poruka
					        poruka = '<div class="myAjaxAlert alert alert-'+data.status+'">'+data.msg+'</div>';

					        // makni sve prethodne    
					        $('.myAjaxAlert').remove();
					        $('#topmsgs').remove();

					        // ubaci ispred H1
					        $('h1').first().before( poruka ); //appending to a <div id="form-errors"></div> inside form

					        if ( ! data.success) {
								//	foreach (data.errors)
							}
					        // disable savebutton
					        $("#savebutton").prop("disabled",true).blur();

					        //jQuery('html,body').animate({scrollTop:0},500);
 							
 							*/
					    }

			});

    }

	$(".btn").mouseup(function(){
	    $(this).blur();
	});



	// AUTOSAVE ---------------------------------------------------------------------------------
	// ------------------------------------------------------------------------------------------
	// timeout
	var autosave;
	// interni counter, nakon 5 unešenih karaktera (pritisnutih tipki) počni odbrojavati ponovo
	var internalCharCounterForAutosaveRestart = 0;
	var maxCharToRestart = 5;

	// snimi textbox
	var saveScrapBook = function (poruka){

		poruka = poruka || 'autosaved';

		// ajax snimi 
		$.ajax({
			type 	: 	'post',
    		data 	: 	{
							"_token" : $("#apptoken").val(),
							"content": $("#myscrapbook").val(),
			    		},
			dataType: 	'json',
    		url 	: 	'/saveScrapBook',
    		error: function(jqXhr){
				if( jqXhr.status === 422 ) {
							        //process validation errors here.
							        errors = jqXhr.responseJSON; //this will get the errors response data.
							     	console.log(errors);
				 	}
			},
			success: function(data){
				//console.log(data);
				resetAutosave();
				disableSaveButton();
			}

		});
		// disable save
		disableSaveButton();
		
		// reci da si snimio
		$("#savemessage").flashIt({
			text: poruka,
			how: 'html',
			time: 500,
		});

	}

	// disable save button
	function disableSaveButton(){
		$("#savebutton").prop('disabled',true);		
		return;
	}
	// resetiraj timeout
	var resetAutosave = function(){
				// obriši stari timeout
				clearTimeout(autosave);
				// resetiraj brojač
				internalCharCounterForAutosaveRestart = 0;
	};

	// fire save on savebutton click
	$("#savebutton").on("click", function(){
		saveScrapBook("saved");
	});


	// fire save ond CTR+S
	var form = document.querySelector('#myscrapbook');
	var mousetrap = new Mousetrap(form);
	mousetrap.bind('mod+s', function(e){
		 if (e.preventDefault) {
	        e.preventDefault();
			e.stopImmediatePropagation();
	    } else {
	        // internet explorer
	        e.returnValue = false;
	    }
		setTimeout(function(){
					resetAutosave();
					saveScrapBook("saved");
		},0); // u setTimeout da bi u FF radilo kak spada
	});



	// enable autosave process on keyup and fire save ond CTR+S
	$("#myscrapbook").on("keyup",function(){

		// povečaj brojač
		internalCharCounterForAutosaveRestart++;

		// ako je odbrojavanje do autosave još nije započelo...
		if ($("#savebutton").prop('disabled')) 
		{

			// enable savebutton
			$("#savebutton").prop('disabled',false);
			// kad odborojiš,snimi
		    autosave = setTimeout(saveScrapBook, 3000);
		    // restartaj brojač
			internalCharCounterForAutosaveRestart = 0;

		} else {

			if (internalCharCounterForAutosaveRestart>=maxCharToRestart) {

				// obriši stari timeout i resetiraj brojač
				resetAutosave();

				// postavi novi timeout
				autosave = setTimeout(saveScrapBook, 3000);

			}

		}


	});


	$("#changepass").on("change",function(){
		if($("#changepass").prop("checked")){
			setChangePassFields('enable');
		} else {
			setChangePassFields('disable');
		}
	});


	function setChangePassFields(state){
		state = state || 'disable';

		if (state=='disable'){
			$("#oldpass").prop("disabled", true);
			$("#newpass").prop("disabled", true);
			$("#newpassconfirm").prop("disabled", true);
		} else { // ili enable...
			$("#oldpass").prop("disabled", false);
			$("#newpass").prop("disabled", false);
			$("#newpassconfirm").prop("disabled", false);
		}

	}

	// ================================================================================================
	// Analytics chained select
	// ========================
	$("#analyticsSelectPartners").on("change",function(){
		// prva vrijednost
		value=$(this).val();
		// enable/disable		
		if (! value>0) {
			disabledAnalyticsSelects("#analyticsSelectPOSes",true);
			disabledAnalyticsSelects("#analyticsSelectUsers",true);
		} else {
			disabledAnalyticsSelects("#analyticsSelectPOSes",false);
			disabledAnalyticsSelects("#analyticsSelectUsers",true);
			fetchSubSelect('/api/partnersposes/'+value,'#analyticsSelectPOSes',true, "All partner's POS", 0);
		}
	});

	$("#analyticsSelectPOSes").on("change",function(){
		// prva vrijednost
		value=$(this).val();
		// enable/disable		
		if (value==0) {
			disabledAnalyticsSelects("#analyticsSelectUsers",true);
		} else {
			disabledAnalyticsSelects("#analyticsSelectUsers",false);
			fetchSubSelect('/api/posusers/'+value,'#analyticsSelectUsers',true, "All POS users", 0);
		}
	});


	fetchSubSelect = function(ajaxUrl,targetSelectSelector,drawSelectAll, selectAllText, selectAllValue){
			$.get(ajaxUrl,{},

					function(data){
						var targetSelect = $(targetSelectSelector);
				        targetSelect.empty();
				        
				        if (drawSelectAll) {
					        // All poses
					        targetSelect.append(
					          	$("<option></option>")
					          		.attr("value",selectAllValue)
					          		.text(selectAllText)
					          	);
				        }

				        // JSON results to options, has ID and NAME property
						$.each(data, function(key, value) {   
				          targetSelect
				          .append($("<option></option>")
				          .attr("value",value.id)
				          .text(value.name)); 
				          //.text(value[a])); 
				        });
				});

	};


	disabledAnalyticsSelects = function(target,state,emptyOnDisabled){
		emptyOnDisabled = (emptyOnDisabled == undefined) ? true : emptyOnDisabled;
		$(target).prop("disabled",state);
		if (state && emptyOnDisabled) $(target).empty();
	}

	// ================================================================================================



	// ================================================================================================
	// Message recipients chained select
	// =================================
	$("#msgrecipientsPartners").on("change",function(e){
		// prva vrijednost
		value=$(this).val();

		// koji je upravo odabran?		
		curr = e.currentTarget.selectedIndex;
		// "All"?
		if (value==null) {
			disabledAnalyticsSelects("#msgrecipientsPoses",true,true);
			disabledAnalyticsSelects("#msgrecipientsUsers",true,true);
		} else {
			disabledAnalyticsSelects("#msgrecipientsPoses",false);
			disabledAnalyticsSelects("#msgrecipientsUsers",true,true);
			fetchSubSelect('/api/partnersposes/'+value,'#msgrecipientsPoses',false);
		}
	});

	$("#msgrecipientsPoses").on("change",function(){
		// prva vrijednost
		value=$(this).val();
		// enable/disable		
		if (value==null) {
			disabledAnalyticsSelects("#msgrecipientsUsers",true,true);
		} else {
			disabledAnalyticsSelects("#msgrecipientsUsers",false);
			fetchSubSelect('/api/posusers/'+value,'#msgrecipientsUsers',false);
		}
	});

	// ================================================================================================




} ); // main
















// SELECT2 HELPER FUNCTIONS =================================================

function selectedItemTemplate(item, container) {
					if(!item.id) 
					{
						$("#realisationsubmit").prop('disabled',true);
						return item.text;
					}
					//return item.title;
					$("#realisationsubmit").prop('disabled',false);
					$("#realisation-pt-box").html(item.element.getAttribute('data-points') +'pt'); //dataset.points
					$("#realisation-pt-box").data("points",item.element.getAttribute('data-points')); //dataset.points
				 	var $item = $(
				  	//  '<span>'+item.title+'</span>'+' '+'<span class="label label-warning">' + item.element.dataset.points +' pt </span> '
				  	  '<span>'+item.title+'</span>'
				 	 );

				  	return $item;
}

function formatItems (item) {
				  if (!item.id) { return item.text; }
				  var $item = $(
				    '<span>'+item.text+'</span>'+' '+'<span class="label label-warning">' + item.element.getAttribute('data-points') +' pt </span> '
				  );
				  return $item;
};


function tmkSelect2MatchAnyKw(params, data) {
				  	// If there are no search terms, return all of the data
				  	if ($.trim(params.term) === '') {
				  		return data;
				  	}
				  	// `params.term` should be the term that is used for searching
				  	// split by " " to get keywords
				  	keywords=(params.term).split(" ");
				  	// `data.text` is the text that is displayed for the data object
					// check if data.text contains all of keywords, if some is missing, return null
					var i;
					for (i = 0; i < keywords.length; i++) {

						if (((data.text).toUpperCase()).indexOf((keywords[i]).toUpperCase()) == -1) 
						  // Return `null` if the term should not be displayed
						return null;

					}
				  	// If here, data.text contains all keywords, so return it.
				  	return data;
				  }

function tmkTypeheadMatchAnyKw(item){

				  	// If there are no search terms, return all of the data
				  	if ($.trim(this.query) === '') {
				  		return item;
				  	}
				  	// `this.query` should be the term that is used for searching
				  	// split by " " to get keywords
				  	keywords=(this.query).split(" ");
				  	// item is the text that is displayed for the data object
					// check if data.text contains all of keywords, if some is missing, return null
					var i;
					for (i = 0; i < keywords.length; i++) {

						if (((item).toUpperCase()).indexOf((keywords[i]).toUpperCase()) == -1) 
						  // Return `null` if the term should not be displayed
						return null;

					}
				  	// If here, item contains all keywords, so return it.
				  	return item;
				  }

// pluginovi....
// flash message

(function($) {

	$.fn.flashIt = function(options){

		options = $.extend({
			text: 'Autosaved',
			time: 1000,
			how:  'before',
			class_name: ''
		}, options);

		return $(this).each(function() {

			if ( $(this).parent().find('.flash_message').get(0) ) return;

			var message = $("<span />", {
				'class': 'flash_message' + options.class_name,
				text: 	options.text
			}).hide().fadeIn('fast');

			$(this)[options.how](message);

			message.delay(options.time).fadeOut('normal', function(){
				$(this).remove();
			});

		});

	};

})(jQuery);


//http://stackoverflow.com/questions/2540277/jquery-counter-to-count-up-to-a-target-number
(function($) {
    $.fn.countTo = function(options) {
        // merge the default plugin settings with the custom options
        options = $.extend({}, $.fn.countTo.defaults, options || {});

        // how many times to update the value, and how much to increment the value on each update
        var loops = Math.ceil(options.speed / options.refreshInterval),
            increment = (options.to - options.from) / loops;

        return $(this).each(function() {
            var _this = this,
                loopCount = 0,
                value = options.from,
                interval = setInterval(updateTimer, options.refreshInterval);

            function updateTimer() {
                value += increment;
                loopCount++;
                //$(_this).html(value.toFixed(options.decimals));
                $(_this).html(value.formatNumber(options.decimals, ',', '.'));

                if (typeof(options.onUpdate) == 'function') {
                    options.onUpdate.call(_this, value);
                }

                if (loopCount >= loops) {
                    clearInterval(interval);
                    value = options.to;

                    if (typeof(options.onComplete) == 'function') {
                        options.onComplete.call(_this, value);
                    }
                }
            }
        });
    };

    $.fn.countTo.defaults = {
        from: 0,  // the number the element should start at
        to: 100,  // the number the element should end at
        speed: 1000,  // how long it should take to count between the target numbers
        refreshInterval: 100,  // how often the element should be updated
        decimals: 0,  // the number of decimal places to show
        onUpdate: null,  // callback method for every time the element is updated,
        onComplete: null,  // callback method for when the element finishes updating
    };
})(jQuery);


// format broj

Number.prototype.formatNumber = function(c, d, t){
    c = (isNaN(c = Math.abs(c))) ? 2 : c;
    d = (d == undefined) ? "." : d;
    t = (t == undefined) ? "," : t;

var n = this, 
    s = n < 0 ? "-" : "", 
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
    j = (j = i.length) > 3 ? j % 3 : 0;


   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };