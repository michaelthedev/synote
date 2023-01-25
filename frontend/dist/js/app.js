// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://www.logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 17 Jul, 2022 01:26PM
// +------------------------------------------------------------------------+
// | 2022 Logad Networks. (Open source project)
// +------------------------------------------------------------------------+

// validate login
function validateLogin() {
	if (localStorage.getItem('synoteUserID') === null) {
		window.location.replace('./login.html');
	}

	$.ajax({
		url: 'api/validate-userID',
		type: 'POST',
		dataType: 'json',
		data: {
			userID: localStorage.getItem('synoteUserID')
		}
	})
	.done(function(response) {
		if (response.error !== false) {
			window.location.replace('./login.html');
		}
	})
	.fail(function() {
		page_error("Something went wrong");
	})
}
// Load notes
function loadNotes() {
	$.ajax({
		url: 'api/get-notes',
		type: 'POST',
		dataType: 'json',
		data: {
			userID: localStorage.getItem('synoteUserID')
		}
	})
	.done(function(response) {
		if (response.error === false) {
			$("#notesPlaceholder").fadeOut();
			if (response.data.length == 0) {
				$("#notesEmpty").addClass('d-none');
			} else {
				notesToHTML(response.data);
				$("#notesDiv").fadeIn();
				if (notesMansory !== null) {
					notesMansory.masonry('destroy');
				}

				notesMansory = $('#notesDiv>div.row-cards').masonry({
					percentPosition : true
				});
				initNotesContextMenu();
			}
		} else {
			page_error(response.message);
		}
	})
	.fail(function() {
		page_error("Something went wrong");
	})
}

function notesToHTML(notes) {
	var html = '';
	$.each(notes, function(index, note) {
		html += `<div class="col-md-6 col-lg-3 mt-2" id="NOTE`+note.id+`" noteid="`+note.id+`">
		    <div class="card card-stackedd">
		        <div class="card-body">`;
			        if (note.title != '' && note.title != null) {
			        	html += `<h3 class="card-title">`+note.title+`</h3>`;
			        }
					html += `<div id="extract" class="text-muted">`+note.extract+`</div>`;
		            html += `<div class="text-muted2" hidden>`+note.content+`</div>
		        </div>
		    </div>
		</div>`;
	});
	$("#notesDiv>div.row-cards").html(html);
}

// Error notification
function page_error(message) {
	toastr.error(message);
}

// Context menu for notes
function initNotesContextMenu() {
	const copyIcon = `<svg viewBox="0 0 24 24" width="13" height="13" stroke="currentColor" stroke-width="2.5" style="margin-right: 7px" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>`;
	const editIcon = `<svg width="14" height="14" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" style="margin-right: 7px" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 15l8.385 -8.415a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3z"></path><path d="M16 5l3 3"></path><path d="M9 7.07a7.002 7.002 0 0 0 1 13.93a7.002 7.002 0 0 0 6.929 -5.999"></path></svg>`;
	const deleteIcon = `<svg viewBox="0 0 24 24" width="13" height="13" stroke="red" stroke-width="2.5" fill="none" style="margin-right: 7px" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1"></path></svg>`;
	const menuItems = [
	    {
	        content: `${copyIcon}Copy`,
	        events: {
	            click: function(e) {
	            	var clickTarget = $(e.target);
	            	var targetElID = clickTarget.closest('ul[targetelid]').attr('targetelid');
	            	var noteCard = $("#"+targetElID);
	            	var noteContent = '';
	            	if (noteCard.find('h3.card-title').length) {
	            		noteContent += noteCard.find('h3.card-title').text() +"\n\n";
	            	}
	            	noteContent += noteCard.find('div.card-body>div.text-muted2').text();
	            	console.log(noteContent);
	            	copyToClipboard(noteContent);
	            }
	            // mouseover: () => console.log("Copy Button Mouseover")
	            // You can use any event listener from here
	        },
	    },
	    {
	        content: `${editIcon}Edit`,
	        events: {
	            click: function (e) {
	            	console.log("edit clicked");
	            	var clickTarget = $(e.target);
	            	var targetElID = clickTarget.closest('ul[targetelid]').attr('targetelid');
	            	var noteCard = $("#"+targetElID);
	            	editNote(noteCard);
	            }
	        },
	    },
	    {
	        content: `<span style='color:red'>${deleteIcon}Delete</span>`,
	        events: {
	            click: function (e) {
	            	console.log("delete clicked");
	            	var clickTarget = $(e.target);
	            	var targetElID = clickTarget.closest('ul[targetelid]').attr('targetelid');
					console.log(targetElID);
	            	var noteCard = $("#"+targetElID);
	            	deleteNote(noteCard);
					const notehtml = document.getElementById(targetElID);
					notehtml.remove();
	            }
	        },
	        // divider: "top" // top, bottom, top-bottom
	    },
	];
	const notesMenu = new ContextMenu({
	    target: "[noteid]",
	    mode: localStorage.getItem("tablerTheme"),
	    menuItems,
	});
	notesMenu.init();
}

function editNote(noteEl) {
	// Define the note we're trying to edit
	$("#editNoteId").val(noteEl.attr('noteid'));

	// Removing the old tinymce because we're editing a new note
	tinyMCE.remove('#notesEditTextArea');
	tinymce.execCommand('mceRemoveEditor',true,"#notesEditTextArea");

	// Set the textarea value to the note's html content
	$("#notesEditTextArea").val(noteEl.find('div.card-body>div.text-muted2').html());
	// set note title
	$("#editNoteTitle").val(noteEl.find('h3.card-title').text());
	// Init tinymce
	tinyMCE.init({
		selector: '#notesEditTextArea',
		height: 500,
		menubar: false,
		statusbar: false,
		plugins: 'advlist autolink lists link image charmap anchor visualblocks fullscreen insertdatetime media',
		toolbar: 'undo redo | formatselect | ' +
	            'bold italic backcolor | alignleft aligncenter ' +
	            'alignright alignjustify | bullist numlist outdent indent | ' +
	            'removeformat',
	    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; -webkit-font-smoothing: antialiased; }',
	    toolbar_location: 'bottom',
	});

	// Show the modal after all the above
	$("#editNoteModal").modal('show');
}

function deleteNote(noteEl) {
	if (confirm('Are you sure you want to delete this note?') === true) {
		$.ajax({
		    url: 'api/delete-note',
		    type: 'POST',
		    dataType: 'json',
		    data: {
		        userID: localStorage.getItem('synoteUserID'),
		        noteID : noteEl.attr('noteid')
		    }
		})
		.done(function(response) {
		    if (response.error === false) {
		        toastr.success(response.message);
		        loadNotes();
		    } else {
		        page_error(response.message);
		    }
		})
		.fail(function() {
		    page_error("Something went wrong");
		})
	}
}

function copyToClipboard(text) {
    toastr.success('Text copied');
    if (window.clipboardData && window.clipboardData.setData) {
        return window.clipboardData.setData("Text", text);
    }
    else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
        var textarea = document.createElement("textarea");
        textarea.textContent = text;
        textarea.style.position = "fixed";
        document.body.appendChild(textarea);
        textarea.select();
        try {
            return document.execCommand("copy");
        }
        catch (ex) {
            return prompt("Copy to clipboard: Ctrl+C, Enter", text);
        }
        finally {
            document.body.removeChild(textarea);
        }
    }
}


// Start QR code scanner
function startQRScanner() {
	scanner.start();
	$("#qr-video-container").slideDown();
	$("#captureQR").hide();
	$("#stopCaptureQR").show();
}

// Stop scanner
function stopQRScanner() {
	scanner.stop();
	$("#qr-video-container").slideUp();
	$("#stopCaptureQR").hide();
	$("#captureQR").show();
}

$(document).ready(function($) {

	// check for user is logged in
	validateLogin();

	notesMansory = null;
	// Delay notes load
	setTimeout(function() {
		loadNotes();
		setInterval(function () {
			loadNotes()
		}, 3000);
	}, 1000)

	$(".newNoteBtn").click(function(event) {
		$("#newNoteModal").modal('show');
	});

	$("#connectDeviceBtn").click(function(event) {
		$("#connectDeviceModal").modal('show');
	});
	$('#connectDeviceModal').on('hidden.bs.modal', function () {
	    stopQRScanner();
	});

	//
	tinyMCE.init({
		selector: '#notesTextArea',
		height: 500,
		menubar: false,
		statusbar: false,
		plugins: 'advlist autolink lists link image charmap anchor visualblocks fullscreen insertdatetime media',
		toolbar: 'undo redo | formatselect | ' +
	            'bold italic backcolor | alignleft aligncenter ' +
	            'alignright alignjustify | bullist numlist outdent indent | ' +
	            'removeformat',
	    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; -webkit-font-smoothing: antialiased; }',
	    toolbar_location: 'bottom',
	});

	$("#newNoteForm").submit(function(event) {
		event.preventDefault();
		var btn = $(this).find('[type=submit]');
		var btn_text = btn.text();
		btn.addClass('disabled');
		btn.attr('disabled', true);
		btn.text('please wait');

		var formData = new FormData($(this)[0]);
		formData.append('userID', localStorage.getItem('synoteUserID'));
		// formData.append('content', tinyMCE.activeEditor.getContent());
		
		$.ajax({
			url: 'api/new-note',
			type: "POST",
			data: formData,
			dataType: "json",
			cache: false,
			contentType: false,
			processData: false,
			error: function (xhr) {
			    if (xhr.status == 404 || xhr.status == 500) {
			        page_error("An unexpected error seems to have occurred. Now that we know, we're working to fix it ☺. ERROR : "+xhr.status);
			    }
			}
		})
		.done(function(response) {
			if (response.error === false) {
				toastr.success(response.message);
				$("#newNoteModal").modal('hide');
				loadNotes();
			} else {
				page_error(response.message);
			}
		})
		.fail(function(xhr) {
			console.log(xhr);
		})
		.always(function() {
			btn.text(btn_text);
			btn.removeClass("disabled");
			btn.removeAttr("disabled");
		});
	});

	$("#editNoteForm").submit(function(event) {
		event.preventDefault();
		var btn = $(this).find('[type=submit]');
		var btn_text = btn.text();
		btn.addClass('disabled');
		btn.attr('disabled', true);
		btn.text('please wait');

		var formData = new FormData($(this)[0]);
		formData.append('userID', localStorage.getItem('synoteUserID'));
		formData.append('content', tinyMCE.activeEditor.getContent());
		$.ajax({
			url: 'api/edit-note',
			type: "POST",
			data: formData,
			dataType: "json",
			cache: false,
			contentType: false,
			processData: false,
			error: function (xhr) {
			    if (xhr.status == 404 || xhr.status == 500) {
			        page_error("An unexpected error seems to have occurred. Now that we know, we're working to fix it ☺. ERROR : "+xhr.status);
			    }
			}
		})
		.done(function(response) {
			if (response.error === false) {
				toastr.success(response.message);
				$("#editNoteModal").modal('hide');
				loadNotes();
			} else {
				page_error(response.message);
			}
		})
		.fail(function(xhr) {
			console.log(xhr);
		})
		.always(function() {
			btn.text(btn_text);
			btn.removeClass("disabled");
			btn.removeAttr("disabled");
		});
	});
});