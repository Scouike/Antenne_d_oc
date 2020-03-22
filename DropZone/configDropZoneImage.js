Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone("#dropzoneImage", { 
            autoProcessQueue: false,
          
		maxFiles: 1,
		maxFilesize: 5, //max taille du fichier 5 MB
		acceptedFiles:".png,.jpg,.gif,.jpeg",
		addRemoveLinks:true,   //permet d'enlever 1  élément
		dictRemoveFile:'Supprimer',  //renome le liens pour enlever un element
		dictDefaultMessage: 'Cliquer ou déposer vos images ici',
		dictInvalidFileType: 'Probleme de type d\'images, les images autorisé sont les jpeg, les png et les gif',
		maxfilesexceeded: function(file) {
			this.removeAllFiles();
			this.addFile(file);
		},
		init: function(){
			var submitButton = document.querySelector('#uploadfiles');
			myDropzone = this;
			submitButton.addEventListener("click", function(){
				myDropzone.processQueue();
			});
			this.on("complete", function(){
				if(this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0){
					var _this = this;
					_this.removeAllFiles();
				}
    
			});
		},
        });
       
        $('#uploadfiles').click(function(){
            myDropzone.processQueue();
        });