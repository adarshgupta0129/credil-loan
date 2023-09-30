<link href="<?php echo base_url(); ?>application/libraries/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
 <script src="<?php echo base_url(); ?>application/libraries/assets/js/jquery.min.js"></script>

<!--jQuery-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!--Plugin JavaScript file-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>   
<link href="<?php echo base_url(); ?>application/libraries/assets/css/loan.css"  rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="container">
<div class="row ">


<div class="row">
  <div class="col-md-12 readCont">
    <h1 class="loanHeading">
      <strong>Personal Loan</strong> EMI Calculator
    </h1>
    <div class="paraGraph readMoreCont" style="height: 108.2px; transition: height 0.2s ease 0s;"> <p class="emiHere">
        <strong></strong>
      </p>
     
    </div>
   
  </div>
</div>

  <div class="col-lg-8 col-12 calcSection">
    <div class="loanCalc">
      <article class="col-md-6 col-lg-8 col-12">
        <div class="ionSlider newCalc">
          <div class="inpt-slider">
            <div class="inpt-statement loan_amount">
              <label for="loan_amount">Loan Amount ( <i class="fa fa-rupee"></i>) </label>
              <input class="inpt inputBox numbersOnly loanAmt" data-maxval="4000000" data-minval="50000" id="loan_amount" maxlength="8" name="mnthsavings" type="text">
            </div>
            <span class="irs js-irs-0 irs-with-grid">
            
              <span class="irs-grid" style="width: 98.1968%; left: 0.801599%;">
                <span class="irs-grid-pol" style="left: 0%"></span>
                <span class="irs-grid-text js-grid-text-0" style="left: 0%; margin-left: 0%;">50K</span>
                <span class="irs-grid-pol small" style="left: 20%"></span>
                <span class="irs-grid-pol small" style="left: 15%"></span>
                <span class="irs-grid-pol small" style="left: 10%"></span>
                <span class="irs-grid-pol small" style="left: 5%"></span>
                <span class="irs-grid-pol" style="left: 25%"></span>
                <span class="irs-grid-text js-grid-text-1" style="left: 25%; visibility: visible; margin-left: 0%;">10L</span>
                <span class="irs-grid-pol small" style="left: 45%"></span>
                <span class="irs-grid-pol small" style="left: 40%"></span>
                <span class="irs-grid-pol small" style="left: 35%"></span>
                <span class="irs-grid-pol small" style="left: 30%"></span>
                <span class="irs-grid-pol" style="left: 50%"></span>
                <span class="irs-grid-text js-grid-text-2" style="left: 50%; visibility: visible; margin-left: 0%;">20L</span>
                <span class="irs-grid-pol small" style="left: 70%"></span>
                <span class="irs-grid-pol small" style="left: 65%"></span>
                <span class="irs-grid-pol small" style="left: 60%"></span>
                <span class="irs-grid-pol small" style="left: 55%"></span>
                <span class="irs-grid-pol" style="left: 75%"></span>
                <span class="irs-grid-text js-grid-text-3" style="left: 75%; visibility: visible; margin-left: 0%;">30L</span>
                <span class="irs-grid-pol small" style="left: 95%"></span>
                <span class="irs-grid-pol small" style="left: 90%"></span>
                <span class="irs-grid-pol small" style="left: 85%"></span>
                <span class="irs-grid-pol small" style="left: 80%"></span>
                <span class="irs-grid-pol" style="left: 100%"></span>
                <span class="irs-grid-text js-grid-text-4" style="left: 100%; margin-left: 0%;">40L</span>
              </span>
              <span class="irs-bar" style="left: 0.901599%; width: 0%;"></span>
              <span class="irs-bar-edge"></span>
              <span class="irs-shadow shadow-single" style="display: none;"></span>
              <span class="irs-slider single" style="left: 0%;"></span>
            </span>
            <input class="sliderInpt irs-hidden-input" id="loanAmtSlider" name="slider" type="hidden" readonly="">
            <div class="dragText">
              <span>50K</span>
              <span class="pull-right">40L</span>
            </div>
          </div>
          <div class="inpt-slider">
            <div class="inpt-statement interest_rate">
              <label for="interest_rate">Interest Rate (p.a)</label>
              <input class="inputBox inpt numbersDecimal" data-maxval="24" data-minval="10.49" id="interest_rate" maxlength="4" name="mnthsavings" type="text">
            </div>
            <span class="irs js-irs-2 irs-with-grid">
             <!--  <span class="irs">
                <span class="irs-line" tabindex="-1">
                  <span class="irs-line-left"></span>
                  <span class="irs-line-mid"></span>
                  <span class="irs-line-right"></span>
                </span>
                <span class="irs-min" style="visibility: hidden;">10.49%</span>
                <span class="irs-max" style="visibility: visible;">22%</span>
                <span class="irs-from" style="visibility: hidden;">0</span>
                <span class="irs-to" style="visibility: hidden;">0</span>
                <span class="irs-single" style="left: -1.127%;">10.49%</span>
              </span> -->
              <span class="irs-grid" style="width: 98.1968%; left: 0.801599%;">
                <span class="irs-grid-pol" style="left: 0%"></span>
                <span class="irs-grid-text js-grid-text-0" style="left: 0%; margin-left: 0%;">10.49%</span>
                <span class="irs-grid-pol small" style="left: 20%"></span>
                <span class="irs-grid-pol small" style="left: 15%"></span>
                <span class="irs-grid-pol small" style="left: 10%"></span>
                <span class="irs-grid-pol small" style="left: 5%"></span>
                <span class="irs-grid-pol" style="left: 25%"></span>
                <span class="irs-grid-text js-grid-text-1" style="left: 25%; visibility: visible; margin-left: 0%;">13.4%</span>
                <span class="irs-grid-pol small" style="left: 45%"></span>
                <span class="irs-grid-pol small" style="left: 40%"></span>
                <span class="irs-grid-pol small" style="left: 35%"></span>
                <span class="irs-grid-pol small" style="left: 30%"></span>
                <span class="irs-grid-pol" style="left: 50%"></span>
                <span class="irs-grid-text js-grid-text-2" style="left: 50%; visibility: visible; margin-left: 0%;">16.2%</span>
                <span class="irs-grid-pol small" style="left: 70%"></span>
                <span class="irs-grid-pol small" style="left: 65%"></span>
                <span class="irs-grid-pol small" style="left: 60%"></span>
                <span class="irs-grid-pol small" style="left: 55%"></span>
                <span class="irs-grid-pol" style="left: 75%"></span>
                <span class="irs-grid-text js-grid-text-3" style="left: 75%; visibility: visible; margin-left: 0%;">19.1%</span>
                <span class="irs-grid-pol small" style="left: 95%"></span>
                <span class="irs-grid-pol small" style="left: 90%"></span>
                <span class="irs-grid-pol small" style="left: 85%"></span>
                <span class="irs-grid-pol small" style="left: 80%"></span>
                <span class="irs-grid-pol" style="left: 100%"></span>
                <span class="irs-grid-text js-grid-text-4" style="left: 100%; margin-left: 0%;">22%</span>
              </span>
              <span class="irs-bar" style="left: 0.901599%; width: 0%;"></span>
              <span class="irs-bar-edge"></span>
              <span class="irs-shadow shadow-single" style="display: none;"></span>
              <span class="irs-slider single" style="left: 0%;"></span>
            </span>
            <input class="sliderInpt irs-hidden-input" id="intrRateSlider" name="slider" type="hidden" readonly="">
            <div class="dragText">
              <span>10.49%</span>
              <span class="pull-right">22%</span>
            </div>
          </div>
          <div class="inpt-slider">
            <div class="inpt-statement tenure">
              <label for="tenure">Tenure (months)</label>
              <input class="inputBox inpt numbersOnly" data-maxval="60" data-minval="1" id="tenure" maxlength="3" name="mnthsavings" type="text">
            </div>
            <span class="irs js-irs-1 irs-with-grid">
              
              <span class="irs-grid" style="width: 98.1968%; left: 0.801599%;">
                <span class="irs-grid-pol" style="left: 0%"></span>
                <span class="irs-grid-text js-grid-text-0" style="left: 0%; margin-left: 0%;">12</span>
                <span class="irs-grid-pol small" style="left: 20%"></span>
                <span class="irs-grid-pol small" style="left: 15%"></span>
                <span class="irs-grid-pol small" style="left: 10%"></span>
                <span class="irs-grid-pol small" style="left: 5%"></span>
                <span class="irs-grid-pol" style="left: 25%"></span>
                <span class="irs-grid-text js-grid-text-1" style="left: 25%; visibility: visible; margin-left: 0%;">24</span>
                <span class="irs-grid-pol small" style="left: 45%"></span>
                <span class="irs-grid-pol small" style="left: 40%"></span>
                <span class="irs-grid-pol small" style="left: 35%"></span>
                <span class="irs-grid-pol small" style="left: 30%"></span>
                <span class="irs-grid-pol" style="left: 50%"></span>
                <span class="irs-grid-text js-grid-text-2" style="left: 50%; visibility: visible; margin-left: 0%;">36</span>
                <span class="irs-grid-pol small" style="left: 70%"></span>
                <span class="irs-grid-pol small" style="left: 65%"></span>
                <span class="irs-grid-pol small" style="left: 60%"></span>
                <span class="irs-grid-pol small" style="left: 55%"></span>
                <span class="irs-grid-pol" style="left: 75%"></span>
                <span class="irs-grid-text js-grid-text-3" style="left: 75%; visibility: visible; margin-left: 0%;">48</span>
                <span class="irs-grid-pol small" style="left: 95%"></span>
                <span class="irs-grid-pol small" style="left: 90%"></span>
                <span class="irs-grid-pol small" style="left: 85%"></span>
                <span class="irs-grid-pol small" style="left: 80%"></span>
                <span class="irs-grid-pol" style="left: 100%"></span>
                <span class="irs-grid-text js-grid-text-4" style="left: 100%; margin-left: 0%;">60</span>
              </span>
              <span class="irs-bar" style="left: 0.901599%; width: 0%;"></span>
              <span class="irs-bar-edge"></span>
              <span class="irs-shadow shadow-single" style="display: none;"></span>
              <span class="irs-slider single" style="left: 0%;"></span>
            </span>
            <input class="sliderInpt irs-hidden-input" id="tensureSlider" name="slider" type="hidden" readonly="">
            <div class="dragText">
              <span>12</span>
              <span class="pull-right">60</span>
            </div>
          </div>
        </div>
      </article>
      <article class="col-md-6 col-lg-4 col-12 px-0">
        <div class="totalBox">
          <div class="finalResult">
            <span>Equated Monthly Installments (EMI)</span>
            <div class="clearfix"></div>
            <i class="fa fa-rupee"></i>
            <span id="lblEMIAmt"></span>
            
          </div>
        </div>
      </article>
    </div>
  </div>
  <div class="col-md-4 col-xs-12" tabindex="0">
    <h3 class="tabHeading  breakHead">
      <strong>Break-up of </strong>Total Payment
    </h3>
    <article class="semiChart">
      <div id="semiChart" data-highcharts-chart="4">
        <div id="highcharts-kkhot2o-18" dir="ltr" class="highcharts-container " style="position: relative; overflow: hidden; width: 358px; height: 168px; text-align: left; line-height: normal; z-index: 0; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
          <svg version="1.1" class="highcharts-root" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Arial, Helvetica, sans-serif;font-size:12px;" xmlns="http://www.w3.org/2000/svg" width="358" height="168" viewBox="0 0 358 168">
            <desc>Created with Highcharts 6.2.0</desc>
            <defs>
              <clipPath id="highcharts-kkhot2o-21">
                <rect x="0" y="0" width="338" height="143" fill="none"></rect>
              </clipPath>
            </defs>
            <rect fill="#ffffff" class="highcharts-background" x="0" y="0" width="358" height="168" rx="0" ry="0"></rect>
            <rect fill="none" class="highcharts-plot-background" x="10" y="10" width="338" height="143"></rect>
            <rect fill="none" class="highcharts-plot-border" data-z-index="1" x="10" y="10" width="338" height="143"></rect>
            <g class="highcharts-series-group" data-z-index="3">
              <g data-z-index="0.1" class="highcharts-series highcharts-series-0 highcharts-pie-series  highcharts-tracker" transform="translate(10,10) scale(1 1)">
                <path fill="#7cb5ec" visibility="hidden" d="M 45.70001022965204 143.65022581098947 A 123.3 123.3 0 0 1 290.2635360416273 121.28308205237629 L 289.280052375434 121.46407895381687 A 122.3 122.3 0 0 0 46.700010146686495 143.64981846459054 Z" class="highcharts-halo highcharts-color-0" data-z-index="-1" fill-opacity="0.25"></path>
                <path fill="#7cb5ec" d="M 45.70001022965204 143.65022581098947 A 123.3 123.3 0 0 1 290.2635360416273 121.28308205237629 L 253.88447522913907 127.9781574366634 A 86.31 86.31 0 0 0 82.69000716075642 143.63515806769263 Z" transform="translate(0,0)" stroke="#ffffff" stroke-width="1" stroke-linejoin="round" class="highcharts-point highcharts-color-0 "></path>
                <path fill="#434348" d="M 290.2857923240924 121.40435672666537 A 123.3 123.3 0 0 1 292.29993835000516 143.47670002055 L 255.3099568450036 143.513690014385 A 86.31 86.31 0 0 0 253.9000546268647 128.06304970866574 Z" transform="translate(0,0)" stroke="#ffffff" stroke-width="1" stroke-linejoin="round" class="highcharts-point highcharts-color-1"></path>
              </g>
              <g data-z-index="0.1" class="highcharts-markers highcharts-series-0 highcharts-pie-series " transform="translate(10,10) scale(1 1)"></g>
            </g>
            <g class="highcharts-exporting-group" data-z-index="3">
              <g class="highcharts-button highcharts-contextbutton" stroke-linecap="round" transform="translate(324,10)">
                <title>Chart context menu</title>
                <rect fill="#ffffff" class=" highcharts-button-box" x="0.5" y="0.5" width="24" height="22" rx="2" ry="2" stroke="none" stroke-width="1"></rect>
                <path fill="#666666" d="M 6 6.5 L 20 6.5 M 6 11.5 L 20 11.5 M 6 16.5 L 20 16.5" class="highcharts-button-symbol" data-z-index="1" stroke="#666666" stroke-width="3"></path>
                <text x="0" data-z-index="1" style="font-weight:normal;color:#333333;cursor:pointer;fill:#333333;" y="12"></text>
              </g>
            </g>
            <text x="179" text-anchor="middle" class="highcharts-title" data-z-index="4" style="color:#333333;font-size:18px;fill:#333333;" y="122"></text>
            <text x="179" text-anchor="middle" class="highcharts-subtitle" data-z-index="4" style="color:#666666;fill:#666666;" y="24"></text>
            <g data-z-index="6" class="highcharts-data-labels highcharts-series-0 highcharts-pie-series  highcharts-tracker" transform="translate(10,10) scale(1 1)" opacity="1" visibility="visible">
              <g class="highcharts-label highcharts-data-label highcharts-data-label-color-0 " data-z-index="1" transform="translate(157,61)">
                <text x="5" data-z-index="1" style="font-size:11px;font-weight:bold;color:white;fill:white;" y="16"></text>
              </g>
              <g class="highcharts-label highcharts-data-label highcharts-data-label-color-1 " data-z-index="1" transform="translate(237,127)">
                <text x="5" data-z-index="1" style="font-size:11px;font-weight:bold;color:white;fill:white;" y="16"></text>
              </g>
            </g>
            <g class="highcharts-legend" data-z-index="7">
              <rect fill="none" class="highcharts-legend-box" rx="0" ry="0" x="0" y="0" width="8" height="8" visibility="hidden"></rect>
              <g data-z-index="1">
                <g></g>
              </g>
            </g>
            <text x="348" class="highcharts-credits" text-anchor="end" data-z-index="8" style="cursor:pointer;color:#999999;font-size:9px;fill:#999999;" y="163">Highcharts.com</text>
            <g class="highcharts-label highcharts-tooltip highcharts-color-0" style="pointer-events:none;white-space:nowrap;" data-z-index="8" transform="translate(82,-9999)" opacity="0" visibility="visible">
              <path fill="none" class="highcharts-label-box highcharts-tooltip-box highcharts-shadow" d="M 3.5 0.5 L 13.5 0.5 C 16.5 0.5 16.5 0.5 16.5 3.5 L 16.5 13.5 C 16.5 16.5 16.5 16.5 13.5 16.5 L 3.5 16.5 C 0.5 16.5 0.5 16.5 0.5 13.5 L 0.5 3.5 C 0.5 0.5 0.5 0.5 3.5 0.5" stroke="#000000" stroke-opacity="0.049999999999999996" stroke-width="5" transform="translate(1, 1)"></path>
              <path fill="none" class="highcharts-label-box highcharts-tooltip-box highcharts-shadow" d="M 3.5 0.5 L 13.5 0.5 C 16.5 0.5 16.5 0.5 16.5 3.5 L 16.5 13.5 C 16.5 16.5 16.5 16.5 13.5 16.5 L 3.5 16.5 C 0.5 16.5 0.5 16.5 0.5 13.5 L 0.5 3.5 C 0.5 0.5 0.5 0.5 3.5 0.5" stroke="#000000" stroke-opacity="0.09999999999999999" stroke-width="3" transform="translate(1, 1)"></path>
              <path fill="none" class="highcharts-label-box highcharts-tooltip-box highcharts-shadow" d="M 3.5 0.5 L 13.5 0.5 C 16.5 0.5 16.5 0.5 16.5 3.5 L 16.5 13.5 C 16.5 16.5 16.5 16.5 13.5 16.5 L 3.5 16.5 C 0.5 16.5 0.5 16.5 0.5 13.5 L 0.5 3.5 C 0.5 0.5 0.5 0.5 3.5 0.5" stroke="#000000" stroke-opacity="0.15" stroke-width="1" transform="translate(1, 1)"></path>
              <path fill="rgba(247,247,247,0.85)" class="highcharts-label-box highcharts-tooltip-box" d="M 3.5 0.5 L 13.5 0.5 C 16.5 0.5 16.5 0.5 16.5 3.5 L 16.5 13.5 C 16.5 16.5 16.5 16.5 13.5 16.5 L 3.5 16.5 C 0.5 16.5 0.5 16.5 0.5 13.5 L 0.5 3.5 C 0.5 0.5 0.5 0.5 3.5 0.5" stroke="#7cb5ec" stroke-width="1"></path>
              <text x="8" data-z-index="1" style="font-size:12px;color:#333333;cursor:default;fill:#333333;" y="20"></text>
            </g>
          </svg>
        </div>
      </div>
      <div class="semiColmn princAmt">
        <span class="princClr">Principal Amt</span>
        <div class="pull-right">
          <i class="fa fa-rupee"></i>
          <span id="princAmt"></span>
        </div>
      </div>
      <div class="semiColmn intAmt">
        <span class="intClr">Interest Amt</span>
        <div class="pull-right">
          <i class="fa fa-rupee"></i>
          <span id="intrAmt"></span>
        </div>
      </div>
      <div class="semiColmn totPay">
        <span>Total Amt Payable</span>
        <div class="pull-right">
          <i class="fa fa-rupee"></i>
          <span id="totalPayAmt"></span>
        </div>
      </div>
    </article>
  </div>
</div>
<div class="paraGraph readMoreCont" style="height: 108.2px; transition: height 0.2s ease 0s;"> <p class="emiHere">
        <strong></strong>
      </p>
     
    </div>

<!-- <div class="row amort">
  <div class="col-md-12">
    <h3 class="tabHeading">
      <strong>Amortization</strong> Schedule
    </h3>
    <div class="table hidden-xs hidden-sm" id="trDynamic">
      <div class="tableRow tableHead">
        <div class="tableCell wid20">Month</div>
        <div class="tableCell wid16">Opening Balance</div>
        <div class="tableCell wid16">Interest paid during the month</div>
        <div class="tableCell wid16">Principal repaid during the month</div>
        <div class="tableCell wid16">Closing Balance</div>
      </div>
      
    </div>
    
  </div>
</div> -->



</div>





<script src="<?php echo base_url(); ?>application/third_party/js/loan.js"></script>
