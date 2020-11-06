$.get(
    "https://www.googleapis.com/youtube/v3/playlistItems", {
      part: "snippet",
      maxResults: 6,
      playlistId: 'UUvwUtIPkSiqlL6b5lTqi9fA',
      key: 'AIzaSyAKJdEJO9a0gtcaEUwHFDxtgszt1PuU1Bs' },
      function(data) {
         var output;
      // paint title of playlist on web page
         $.each(data.items, function(i, item) {  
             output = '<div class="col-lg-4 col-md-6 mt-4 pt-2">'+
                      '<div class="card blog rounded border-0 shadow">'+
                      '<div class="position-relative">'+
                          '<img src="'+item.snippet.thumbnails.maxres.url+'" class="rounded-bottom-0 img-fluid mx-auto d-block" alt="">'+
                          '<div class="job-overlay bg-white"></div>'+
                          '<div class="play-icon">'+
                              '<a href="https://www.youtube.com/watch?v='+item.snippet.resourceId.videoId+'" class="play-btn video-play-icon">'+
                                  '<i class="mdi mdi-play text-primary rounded-circle bg-danger shadow"></i>'+
                              '</a>'+
                          '</div>'+
                      '</div>'+
                      '</div>'+
                  '</div>'
            $("#videoYoutube").append(output); 
          //   console.log(item.snippet.thumbnails.standard.url)        
         }); 

         $('.video-play-icon').magnificPopup({
              disableOn: 375,
              type: 'iframe',
              mainClass: 'mfp-fade',
              removalDelay: 160,
              preloader: false,
              fixedContentPos: false,
          });
          
      }  
   );    