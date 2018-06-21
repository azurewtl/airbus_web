<!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">

    <a class="navbar-brand" href="/">{{ config('app.name') }}</a>

    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">

      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="文档检索">
          <a class="nav-link" href="/search">
            <i class="fa fa-fw fa-search"></i>
            <span class="nav-link-text">Document retrieval</span><!--文档检索-->
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="文档检索">
          <a class="nav-link" href="/production">
            <i class="fa fa-fw fa-search"></i>
            <span class="nav-link-text">Production table retrieval</span><!--生产报表检索-->
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="数据可视化">
          <a class="nav-link" href="/visualze">
            <i class="fa fa-fw fa-area-chart"></i>
            <span class="nav-link-text">Data visualization</span><!--数据可视化-->
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="爬虫数据">
          <a class="nav-link" href="/table?type=1">
            <i class="fa fa-fw fa-table"></i>
            <span class="nav-link-text">Web crawler data</span><!--爬虫数据-->
          </a>
        </li>
      </ul>

      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
    </div>
  </nav>