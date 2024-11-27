<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="dashboard.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/iconoir-icons/iconoir@main/css/iconoir.css" />

</head>

<body>
  <main class="container">
    <div class="menu">
      <div class="avatar">
        <img class="thumb"
          src="https://media.istockphoto.com/id/1156319595/vector/trade-mark-icon-symbol-tm-sign-trademark-vector-black-law.jpg?s=1024x1024&w=is&k=20&c=zDRx3aZ0N3ytmYDSRkGQM3a8NkHYwBJUOi5tfaTFHn4="
          alt="pic" width="60" />
        <span class="name">@tayyab</span>
      </div>
      <nav class="primary">
        <a href="#" class="menu-item active">
          <span class="iconoir-report-columns"></span>
          <span class="desc">Dashboard</span>
        </a>
        <a href="#" class="menu-item">
          <span class="iconoir-google-docs"></span>
          <span class="desc">Reports</span>
        </a>
        <a href="#" class="menu-item">
          <span class="iconoir-table"></span>
          <span class="desc">Stats</span>
        </a>
        <a href="#" class="menu-item">
          <span class="iconoir-bag"></span>
          <span class="desc">Cart</span>
        </a>
        <a href="#" class="menu-item">
          <span class="iconoir-user"></span>
          <span class="desc">Clients</span>
        </a>
        <a href="#" class="menu-item">
          <span class="iconoir-leaderboard"></span>
          <span class="desc">Analytics</span>
        </a>
        <a href="#" class="menu-item">
          <span class="iconoir-settings"></span>
          <span class="desc">Settings</span>
        </a>
      </nav>
      <span class="expander iconoir-arrow-right"></span>
    </div>
    <div class="topbar">
      <h1 class="current">Dashboard</h1>
      <span class="search">
        <label><span class="iconoir-search"></span></label>
        <input class="bar" type="text" placeholder="Search..." />
      </span>
      <nav>
        <a href="#" class="menu-item">Orders</a>
        <a href="#" class="menu-item">Clients</a>
        <a href="#" class="menu-item">Sections</a>
        <a href="#" class="menu-item">Products</a>
      </nav>
    </div>
    <div class="dashboard">
      <div class="cardcolumn">
        <div class="card">
          <header>
            <a class="title" href="#"></a>
            <span class="iconoir-more-vert"></span>
          </header>
          <div class="content"> Lorem ipsum dolor, sit amet consectetur adipisicing elit.</div>
          <div class="meta">
            <span class="iconoir-pin"></span>
            <span class="iconoir-eye-off"></span>
            <span class="iconoir-share-ios"></span>
          </div>
        </div>
        <div class="card">
          <header>
            <a class="title" href="#"></a>
            <span class="iconoir-more-vert"></span>
          </header>
          <div class="content"> Lorem ipsum dolor, sit amet consectetur adipisicing elit.</div>
          <div class="meta">
            <span class="iconoir-pin"></span>
            <span class="iconoir-eye-off"></span>
            <span class="iconoir-share-ios"></span>
          </div>
        </div>
      </div>
      <div class="cardcolumn">
        <div class="card">
          <header>
            <a class="title" href="#"></a>
            <span class="iconoir-more-vert"></span>
          </header>
          <div class="content"> Lorem ipsum dolor, sit amet consectetur adipisicing elit.</div>
          <div class="meta">
            <span class="iconoir-pin"></span>
            <span class="iconoir-eye-off"></span>
            <span class="iconoir-share-ios"></span>
          </div>
        </div>
        <div class="card">
          <header>
            <a class="title" href="#"></a>
            <span class="iconoir-more-vert"></span>
          </header>
          <div class="content"> Lorem ipsum dolor, sit amet consectetur adipisicing elit.</div>
          <div class="meta">
            <span class="iconoir-pin"></span>
            <span class="iconoir-eye-off"></span>
            <span class="iconoir-share-ios"></span>
          </div>
        </div>
      </div>
      <div class="cardcolumn">
        <div class="card">
          <header>
            <a class="title" href="#"></a>
            <span class="iconoir-more-vert"></span>
          </header>
          <div class="content"> Lorem ipsum dolor, sit amet consectetur adipisicing elit.</div>
          <div class="meta">
            <span class="iconoir-pin"></span>
            <span class="iconoir-eye-off"></span>
            <span class="iconoir-share-ios"></span>
          </div>
        </div>
        <div class="card">
          <header>
            <a class="title" href="#"></a>
            <span class="iconoir-more-vert"></span>
          </header>
          <div class="content"> Lorem ipsum dolor, sit amet consectetur adipisicing elit.</div>
          <div class="meta">
            <span class="iconoir-pin"></span>
            <span class="iconoir-eye-off"></span>
            <span class="iconoir-share-ios"></span>
          </div>
        </div>
      </div>
    </div>
    <div class="side">
      <div class="card weather">
        <img class="condition"
          src="https://user-images.githubusercontent.com/30212452/203724734-5f748507-7ae4-49f9-89f8-7fce3112cd95.png" />
        <div class="content"></div>
        <div class="meta">
          <span class="location">
            <span class="iconoir-pin-alt"></span>
            Karachi, Pak
          </span>
          <div class="datetime">
            <span class="iconoir-calendar"></span>
            <span class="date">11 Oct, 2024</span>
            <?php
            date_default_timezone_set('Asia/Karachi');
            ?>
            <span class="time"><?php echo date("h:i"); ?></span>
          </div>
        </div>
      </div>
      <div class="card">
        <header>Schedule</header>
        <div class="content">
          <ul>
            <li>(15:30) Deliver the project to client</li>
            <li>(18:00) Meet Mike @ White Goose</li>
            <li>(19:30) Dinner with Mary @ Kit-Bar</li>
            <li>(22:00) Watch the Falcons match</li>
            <li>(23:30) Headspace Meditate</li>
          </ul>
        </div>
      </div>
    </div>
  </main>
  <div class="video">
    <video src="https://user-images.githubusercontent.com/30212452/203724691-9e93bf50-df02-4034-9743-dfe32d18bf58.mp4"
      muted playsinline autoplay loop></video>
  </div>
</body>