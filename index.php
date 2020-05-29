<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="library/bootstrap-4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="library/css/css.css">
   
</head>
<body>
    <div class="menu">
            <nav class="navbar  navbar-inverse  ">                  
                <a href="#" class="navbar-brand"><img src="library/image/dblp.png" style="width:150px; height:150px;" >  </a>    
                 <header>
                    <h2><strong>HỆ KHUYẾN NGHỊ HỢP TÁC NGHIÊN CỨU</strong></h2>
                    <h6><i>DỰA TRÊN DỮ LIỆU THU THẬP TỪ DBLP</i></h6>
                </header>
            </nav>
    </div>
    
        <h1><strong>CHƯƠNG TRÌNH THỬ NGHIỆM</strong></h1>
      
    <!-- <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 mt-5">
                <button class="btn btn-primary" onclick="return window.location.href='addData.php'">Add data</button>
            </div>
        </div>
    </div> -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 mt-5">
            <form action="#" method="post">
                <label for="field">Lĩnh vực nghiên cứu:</label>
                <select id = "fiedld"> 
                <option value="#">Information Technology</option>
                </select>
            </form>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 mt-5">
               
                 <form action="selectauthor.php" method="get">
                   Tìm tác giả: <input type="text" name="search" />
                    <input type="submit" name="ok" value="search" />
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 mt-5">
            <form action="#" method="post">
                <label for="field">Chủ đề nghiên cứu:</label>
                <select id = "fiedld"> 
                <option value="#">Information Technology</option>
                </select>
            </form>
            </div>
        </div>
    </div>    
    

    <footer>
        <div class="contact">
            <h2>-2020-</h2>
        </div>     
        </footer>

</body>
</html>