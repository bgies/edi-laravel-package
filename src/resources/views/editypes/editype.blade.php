@extends('layouts.layout')

@section('title', 'EDI Type')


@section('content')
        
	<p>
		<div class="center"><h3> {{ $ediType->edt_name }}</h3></div>
	</p>
<!-- 
	<h4>Field Names</h4>
	<p>{{ print_r(array_keys($fields), true) }}</p>  
 -->
 
<form class="edi-grid-bg">
	<div class="mb-3 row">
   		<label for="staticId" class="col-sm-2 col-form-label disabled">Id</label>
		<div class="col-sm-10">
      		<input type="text" readonly class="form-control-plaintext disabled" id="staticId" value="{{ $ediType->id }}">
    	</div>
	</div>    	
    
	<div class="mb-3">
   		<label for="edt_name" class="form-label">EDI Type Name</label>
   		<input type="input" class="form-control" id="edt_name" aria-describedby="edtNameHelp" value="{{ $ediType->edt_name }}">
		<div id="edtNameHelp" class="form-text">Your EDI Type name should be short, but descriptive eg. "Read 850 Customer 1" or "Customer 2 Write 850"</div>
	</div>
 
   <div class="mb-3">
   	<label for="edt_edi_standard" class="form-label">EDI Standard</label>
		<select id="edt_edi_standard" class="mb-3 form-select" aria-label=".edt_edi_standard">
			<option value="X12" {{ $ediType->edt_edi_standard == 'X12' ? 'selected' : '' }}>X12</option>
			<option value="EDIFACT" {{ $ediType->edt_edi_standard == 'EDIFACT' ? 'selected' : '' }}>EDIFACT</option>
		</select>
	</div>
	  
	<div class="mb-3">
		<label for="edt_transaction_set_name" class="form-label">Transaction Set</label>   
		<select id="edt_transaction_set_name" class="mb-3 form-select" aria-label=".edt_transaction_set_name">
		   <option value="100" {{ $ediType->edt_transaction_set_name == '100' ? 'selected' : '' }}>100 - Insurance Plan Description</option>
		   <option value="101" {{ $ediType->edt_transaction_set_name == '101' ? 'selected' : '' }}>101 - Name and Address Lists</option>
		   <option value="102" {{ $ediType->edt_transaction_set_name == '102' ? 'selected' : '' }}>102 - Associated Data</option>
		   <option value="103" {{ $ediType->edt_transaction_set_name == '103' ? 'selected' : '' }}>103 - Abandoned Property Filings</option>
		   <option value="104" {{ $ediType->edt_transaction_set_name == '104' ? 'selected' : '' }}>104 - Air Shipment Information</option>
		   <option value="105" {{ $ediType->edt_transaction_set_name == '105' ? 'selected' : '' }}>105 - Business Entity Filings</option>
		   <option value="106" {{ $ediType->edt_transaction_set_name == '106' ? 'selected' : '' }}>106 - Motor Carrier Rate Proposal</option>
		   <option value="107" {{ $ediType->edt_transaction_set_name == '107' ? 'selected' : '' }}>107 - Request for Motor Carrier Rate Proposal</option>
		   <option value="108" {{ $ediType->edt_transaction_set_name == '108' ? 'selected' : '' }}>108 - Response to a Motor Carrier Rate Proposal</option>
		   <option value="109" {{ $ediType->edt_transaction_set_name == '109' ? 'selected' : '' }}>109 - Vessel Content Details</option>
		   <option value="110" {{ $ediType->edt_transaction_set_name == '110' ? 'selected' : '' }}>110 - Air Freight Details and Invoice</option>
		   <option value="111" {{ $ediType->edt_transaction_set_name == '111' ? 'selected' : '' }}>111 - Individual Insurance Policy and Client Information</option>
		   <option value="112" {{ $ediType->edt_transaction_set_name == '112' ? 'selected' : '' }}>112 - Property Damage Report</option>
		   <option value="120" {{ $ediType->edt_transaction_set_name == '120' ? 'selected' : '' }}>120 - Vehicle Shipping Order</option>
		   <option value="121" {{ $ediType->edt_transaction_set_name == '121' ? 'selected' : '' }}>121 - Vehicle Service</option>
		   <option value="124" {{ $ediType->edt_transaction_set_name == '124' ? 'selected' : '' }}>124 - Vehicle Damage</option>
		   <option value="125" {{ $ediType->edt_transaction_set_name == '125' ? 'selected' : '' }}>125 - Multilevel Railcar Load Details</option>
		   <option value="126" {{ $ediType->edt_transaction_set_name == '126' ? 'selected' : '' }}>126 - Vehicle Application Advice</option>
		   <option value="127" {{ $ediType->edt_transaction_set_name == '127' ? 'selected' : '' }}>127 - Vehicle Baying Order</option>
		   <option value="128" {{ $ediType->edt_transaction_set_name == '128' ? 'selected' : '' }}>128 - Dealer Information</option>
		   <option value="129" {{ $ediType->edt_transaction_set_name == '129' ? 'selected' : '' }}>129 - Vehicle Carrier Rate Update</option>
		   <option value="130" {{ $ediType->edt_transaction_set_name == '130' ? 'selected' : '' }}>130 - Student Educational Record (Transcript)</option>
		   <option value="131" {{ $ediType->edt_transaction_set_name == '131' ? 'selected' : '' }}>131 - Student Educational Record (Transcript) Acknowledgement</option>
		   <option value="135" {{ $ediType->edt_transaction_set_name == '135' ? 'selected' : '' }}>135 - Student Aid Origination Record</option>
		   <option value="138" {{ $ediType->edt_transaction_set_name == '138' ? 'selected' : '' }}>138 - Education Testing Results Request and Report</option>
		   <option value="139" {{ $ediType->edt_transaction_set_name == '139' ? 'selected' : '' }}>139 - Student Loan Guarantee Result</option>
		   <option value="140" {{ $ediType->edt_transaction_set_name == '140' ? 'selected' : '' }}>140 - Product Registration</option>
		   <option value="141" {{ $ediType->edt_transaction_set_name == '141' ? 'selected' : '' }}>141 - Product Service Claim Response</option>
		   <option value="142" {{ $ediType->edt_transaction_set_name == '142' ? 'selected' : '' }}>142 - Product Service Claim</option>
		   <option value="143" {{ $ediType->edt_transaction_set_name == '143' ? 'selected' : '' }}>143 - Product Service Notification</option>
		   <option value="144" {{ $ediType->edt_transaction_set_name == '144' ? 'selected' : '' }}>144 - Student Loan Transfer and Status Verification</option>
		   <option value="146" {{ $ediType->edt_transaction_set_name == '146' ? 'selected' : '' }}>146 - Request for Student Educational Record (Transcript)</option>
		   <option value="147" {{ $ediType->edt_transaction_set_name == '147' ? 'selected' : '' }}>147 - Response to Request for Student Educational Record (Transcript)</option>
		   <option value="148" {{ $ediType->edt_transaction_set_name == '148' ? 'selected' : '' }}>148 - Report of Injury</option>
		   <option value="149" {{ $ediType->edt_transaction_set_name == '149' ? 'selected' : '' }}>149 - Notice of Tax Adjustment or Assessment</option>
		   <option value="150" {{ $ediType->edt_transaction_set_name == '150' ? 'selected' : '' }}>150 - Tax Rate Notification</option>
		   <option value="151" {{ $ediType->edt_transaction_set_name == '151' ? 'selected' : '' }}>151 - Electronic Filing of Tax Return Data Acknowledgement</option>
		   <option value="152" {{ $ediType->edt_transaction_set_name == '152' ? 'selected' : '' }}>152 - Statistical Government Information</option>
		   <option value="153" {{ $ediType->edt_transaction_set_name == '153' ? 'selected' : '' }}>153 - Unemployment Insurance Tax Claim or Charge Information</option>
		   <option value="154" {{ $ediType->edt_transaction_set_name == '154' ? 'selected' : '' }}>154 - Secured Interest Filing</option>
		   <option value="155" {{ $ediType->edt_transaction_set_name == '155' ? 'selected' : '' }}>155 - Business Credit Report</option>
		   <option value="157" {{ $ediType->edt_transaction_set_name == '157' ? 'selected' : '' }}>157 - Notice of Power of Attorney</option>
		   <option value="159" {{ $ediType->edt_transaction_set_name == '159' ? 'selected' : '' }}>159 - Motion Picture Booking Confirmation</option>
		   <option value="160" {{ $ediType->edt_transaction_set_name == '160' ? 'selected' : '' }}>160 - Transportation Automatic Equipment Identification</option>
		   <option value="161" {{ $ediType->edt_transaction_set_name == '161' ? 'selected' : '' }}>161 - Train Sheet</option>
		   <option value="163" {{ $ediType->edt_transaction_set_name == '163' ? 'selected' : '' }}>163 - Transportation Appointment Schedule Information</option>
		   <option value="170" {{ $ediType->edt_transaction_set_name == '170' ? 'selected' : '' }}>170 - Revenue Receipts Statement</option>
		   <option value="175" {{ $ediType->edt_transaction_set_name == '175' ? 'selected' : '' }}>175 - Court and Law Enforcement Notice</option>
		   <option value="176" {{ $ediType->edt_transaction_set_name == '176' ? 'selected' : '' }}>176 - Court Submission</option>
		   <option value="180" {{ $ediType->edt_transaction_set_name == '180' ? 'selected' : '' }}>180 - Return Merchandise Authorization and Notification</option>
		   <option value="185" {{ $ediType->edt_transaction_set_name == '185' ? 'selected' : '' }}>185 - Royalty Regulatory Report</option>
		   <option value="186" {{ $ediType->edt_transaction_set_name == '186' ? 'selected' : '' }}>186 - Insurance Underwriting Requirements Reporting</option>
		   <option value="187" {{ $ediType->edt_transaction_set_name == '187' ? 'selected' : '' }}>187 - Premium Audit Request and Return</option>
		   <option value="188" {{ $ediType->edt_transaction_set_name == '188' ? 'selected' : '' }}>188 - Educational Course Inventory</option>
		   <option value="189" {{ $ediType->edt_transaction_set_name == '189' ? 'selected' : '' }}>189 - Application for Admission to Educational Institutions</option>
		   <option value="190" {{ $ediType->edt_transaction_set_name == '190' ? 'selected' : '' }}>190 - Student Enrollment Verification</option>
		   <option value="191" {{ $ediType->edt_transaction_set_name == '191' ? 'selected' : '' }}>191 - Student Loan Pre-Claims and Claims</option>
		   <option value="194" {{ $ediType->edt_transaction_set_name == '194' ? 'selected' : '' }}>194 - Grant or Assistance Application</option>
		   <option value="195" {{ $ediType->edt_transaction_set_name == '195' ? 'selected' : '' }}>195 - Federal Communications Commission (FCC) License Application</option>
		   <option value="196" {{ $ediType->edt_transaction_set_name == '196' ? 'selected' : '' }}>196 - Contractor Cost Data Reporting</option>
		   <option value="197" {{ $ediType->edt_transaction_set_name == '197' ? 'selected' : '' }}>197 - Real Estate Title Evidence</option>
		   <option value="198" {{ $ediType->edt_transaction_set_name == '198' ? 'selected' : '' }}>198 - Loan Verification Information</option>
		   <option value="199" {{ $ediType->edt_transaction_set_name == '199' ? 'selected' : '' }}>199 - Real Estate Settlement Information</option>
		   <option value="200" {{ $ediType->edt_transaction_set_name == '200' ? 'selected' : '' }}>200 - Mortgage Credit Report</option>
		   <option value="201" {{ $ediType->edt_transaction_set_name == '201' ? 'selected' : '' }}>201 - Residential Loan Application</option>
		   <option value="202" {{ $ediType->edt_transaction_set_name == '202' ? 'selected' : '' }}>202 - Secondary Mortgage Market Loan Delivery</option>
		   <option value="203" {{ $ediType->edt_transaction_set_name == '203' ? 'selected' : '' }}>203 - Secondary Mortgage Market Investor Report</option>
		   <option value="204" {{ $ediType->edt_transaction_set_name == '204' ? 'selected' : '' }}>204 - Motor Carrier Load Tender</option>
		   <option value="205" {{ $ediType->edt_transaction_set_name == '205' ? 'selected' : '' }}>205 - Mortgage Note</option>
		   <option value="206" {{ $ediType->edt_transaction_set_name == '206' ? 'selected' : '' }}>206 - Real Estate Inspection</option>
		   <option value="210" {{ $ediType->edt_transaction_set_name == '210' ? 'selected' : '' }}>210 - Motor Carrier Freight Details and Invoice</option>
		   <option value="211" {{ $ediType->edt_transaction_set_name == '211' ? 'selected' : '' }}>211 - Motor Carrier Bill of Lading</option>
		   <option value="212" {{ $ediType->edt_transaction_set_name == '212' ? 'selected' : '' }}>212 - Motor Carrier Delivery Trailer Manifest</option>
		   <option value="213" {{ $ediType->edt_transaction_set_name == '213' ? 'selected' : '' }}>213 - Motor Carrier Shipment Status Inquiry</option>
		   <option value="214" {{ $ediType->edt_transaction_set_name == '214' ? 'selected' : '' }}>214 - Transportation Carrier Shipment Status Message</option>
		   <option value="215" {{ $ediType->edt_transaction_set_name == '215' ? 'selected' : '' }}>215 - Motor Carrier Pick-up Manifest</option>
		   <option value="216" {{ $ediType->edt_transaction_set_name == '216' ? 'selected' : '' }}>216 - Motor Carrier Shipment Pick-up Notification</option>
		   <option value="217" {{ $ediType->edt_transaction_set_name == '217' ? 'selected' : '' }}>217 - Motor Carrier Loading and Route Guide</option>
		   <option value="218" {{ $ediType->edt_transaction_set_name == '218' ? 'selected' : '' }}>218 - Motor Carrier Tariff Information</option>
		   <option value="219" {{ $ediType->edt_transaction_set_name == '219' ? 'selected' : '' }}>219 - Logistics Service Request</option>
		   <option value="220" {{ $ediType->edt_transaction_set_name == '220' ? 'selected' : '' }}>220 - Logistics Service Response</option>
		   <option value="222" {{ $ediType->edt_transaction_set_name == '222' ? 'selected' : '' }}>222 - Cartage Work Assignment</option>
		   <option value="223" {{ $ediType->edt_transaction_set_name == '223' ? 'selected' : '' }}>223 - Consolidators Freight Bill and Invoice</option>
		   <option value="224" {{ $ediType->edt_transaction_set_name == '224' ? 'selected' : '' }}>224 - Motor Carrier Summary Freight Bill Manifest</option>
		   <option value="225" {{ $ediType->edt_transaction_set_name == '225' ? 'selected' : '' }}>225 - Response to a Cartage Work Assignment</option>
		   <option value="240" {{ $ediType->edt_transaction_set_name == '240' ? 'selected' : '' }}>240 - Motor Carrier Package Status</option>
		   <option value="242" {{ $ediType->edt_transaction_set_name == '242' ? 'selected' : '' }}>242 - Data Status Tracking</option>
		   <option value="244" {{ $ediType->edt_transaction_set_name == '244' ? 'selected' : '' }}>244 - Product Source Information</option>
		   <option value="248" {{ $ediType->edt_transaction_set_name == '248' ? 'selected' : '' }}>248 - Account Assignment/Inquiry and Service/Status</option>
		   <option value="249" {{ $ediType->edt_transaction_set_name == '249' ? 'selected' : '' }}>249 - Animal Toxicological Data</option>
		   <option value="250" {{ $ediType->edt_transaction_set_name == '250' ? 'selected' : '' }}>250 - Purchase Order Shipment Management Document</option>
		   <option value="251" {{ $ediType->edt_transaction_set_name == '251' ? 'selected' : '' }}>251 - Pricing Support</option>
		   <option value="252" {{ $ediType->edt_transaction_set_name == '252' ? 'selected' : '' }}>252 - Insurance Producer Administration</option>
		   <option value="255" {{ $ediType->edt_transaction_set_name == '255' ? 'selected' : '' }}>255 - Underwriting Information Services</option>
		   <option value="256" {{ $ediType->edt_transaction_set_name == '256' ? 'selected' : '' }}>256 - Periodic Compensation</option>
		   <option value="260" {{ $ediType->edt_transaction_set_name == '260' ? 'selected' : '' }}>260 - Application for Mortgage Insurance Benefits</option>
		   <option value="261" {{ $ediType->edt_transaction_set_name == '261' ? 'selected' : '' }}>261 - Real Estate Information Request</option>
		   <option value="262" {{ $ediType->edt_transaction_set_name == '262' ? 'selected' : '' }}>262 - Real Estate Information Report</option>
		   <option value="263" {{ $ediType->edt_transaction_set_name == '263' ? 'selected' : '' }}>263 - Residential Mortgage Insurance Application Response</option>
		   <option value="264" {{ $ediType->edt_transaction_set_name == '264' ? 'selected' : '' }}>264 - Mortgage Loan Default Status</option>
		   <option value="265" {{ $ediType->edt_transaction_set_name == '265' ? 'selected' : '' }}>265 - Real Estate Title Insurance Services Order</option>
		   <option value="266" {{ $ediType->edt_transaction_set_name == '266' ? 'selected' : '' }}>266 - Mortgage or Property Record Change Notification</option>
		   <option value="267" {{ $ediType->edt_transaction_set_name == '267' ? 'selected' : '' }}>267 - Individual Life</option>
		   <option value="268" {{ $ediType->edt_transaction_set_name == '268' ? 'selected' : '' }}>268 - Annuity Activity</option>
		   <option value="270" {{ $ediType->edt_transaction_set_name == '270' ? 'selected' : '' }}>270 - Eligibility</option>
		   <option value="271" {{ $ediType->edt_transaction_set_name == '271' ? 'selected' : '' }}>271 - Eligibility</option>
		   <option value="272" {{ $ediType->edt_transaction_set_name == '272' ? 'selected' : '' }}>272 - Property and Casualty Loss Notification</option>
		   <option value="273" {{ $ediType->edt_transaction_set_name == '273' ? 'selected' : '' }}>273 - Insurance/Annuity Application Status</option>
		   <option value="274" {{ $ediType->edt_transaction_set_name == '274' ? 'selected' : '' }}>274 - Healthcare Provider Information</option>
		   <option value="275" {{ $ediType->edt_transaction_set_name == '275' ? 'selected' : '' }}>275 - Patient Information</option>
		   <option value="276" {{ $ediType->edt_transaction_set_name == '276' ? 'selected' : '' }}>276 - Health Care Claim Status Request</option>
		   <option value="277" {{ $ediType->edt_transaction_set_name == '277' ? 'selected' : '' }}>277 - Health Care Claim Status Notification</option>
		   <option value="278" {{ $ediType->edt_transaction_set_name == '278' ? 'selected' : '' }}>278 - Health Care Services Review Information</option>
		   <option value="280" {{ $ediType->edt_transaction_set_name == '280' ? 'selected' : '' }}>280 - Voter Registration Information</option>
		   <option value="283" {{ $ediType->edt_transaction_set_name == '283' ? 'selected' : '' }}>283 - Tax or Fee Exemption Certification</option>
		   <option value="284" {{ $ediType->edt_transaction_set_name == '284' ? 'selected' : '' }}>284 - Commercial Vehicle Safety Reports</option>
		   <option value="285" {{ $ediType->edt_transaction_set_name == '285' ? 'selected' : '' }}>285 - Commercial Vehicle Safety and Credentials Information Exchange</option>
		   <option value="286" {{ $ediType->edt_transaction_set_name == '286' ? 'selected' : '' }}>286 - Commercial Vehicle Credentials</option>
		   <option value="288" {{ $ediType->edt_transaction_set_name == '288' ? 'selected' : '' }}>288 - Wage Determination</option>
		   <option value="290" {{ $ediType->edt_transaction_set_name == '290' ? 'selected' : '' }}>290 - Cooperative Advertising Agreements</option>
		   <option value="300" {{ $ediType->edt_transaction_set_name == '300' ? 'selected' : '' }}>300 - Reservation (Booking Request) (Ocean)</option>
		   <option value="301" {{ $ediType->edt_transaction_set_name == '301' ? 'selected' : '' }}>301 - Confirmation (Ocean)</option>
		   <option value="303" {{ $ediType->edt_transaction_set_name == '303' ? 'selected' : '' }}>303 - Booking Cancellation (Ocean)</option>
		   <option value="304" {{ $ediType->edt_transaction_set_name == '304' ? 'selected' : '' }}>304 - Shipping Instructions</option>
		   <option value="309" {{ $ediType->edt_transaction_set_name == '309' ? 'selected' : '' }}>309 - Customs Manifest</option>
		   <option value="310" {{ $ediType->edt_transaction_set_name == '310' ? 'selected' : '' }}>310 - Freight Receipt and Invoice (Ocean)</option>
		   <option value="311" {{ $ediType->edt_transaction_set_name == '311' ? 'selected' : '' }}>311 - Canadian Customs Information</option>
		   <option value="312" {{ $ediType->edt_transaction_set_name == '312' ? 'selected' : '' }}>312 - Arrival Notice (Ocean)</option>
		   <option value="313" {{ $ediType->edt_transaction_set_name == '313' ? 'selected' : '' }}>313 - Shipment Status Inquiry (Ocean)</option>
		   <option value="315" {{ $ediType->edt_transaction_set_name == '315' ? 'selected' : '' }}>315 - Status Details (Ocean)</option>
		   <option value="317" {{ $ediType->edt_transaction_set_name == '317' ? 'selected' : '' }}>317 - Delivery/Pickup Order</option>
		   <option value="319" {{ $ediType->edt_transaction_set_name == '319' ? 'selected' : '' }}>319 - Terminal Information</option>
		   <option value="322" {{ $ediType->edt_transaction_set_name == '322' ? 'selected' : '' }}>322 - Terminal Operations and Intermodal Ramp Activity</option>
		   <option value="323" {{ $ediType->edt_transaction_set_name == '323' ? 'selected' : '' }}>323 - Vessel Schedule and Itinerary (Ocean)</option>
		   <option value="324" {{ $ediType->edt_transaction_set_name == '324' ? 'selected' : '' }}>324 - Vessel Stow Plan (Ocean)</option>
		   <option value="325" {{ $ediType->edt_transaction_set_name == '325' ? 'selected' : '' }}>325 - Consolidation of Goods In Container</option>
		   <option value="326" {{ $ediType->edt_transaction_set_name == '326' ? 'selected' : '' }}>326 - Consignment Summary List</option>
		   <option value="350" {{ $ediType->edt_transaction_set_name == '350' ? 'selected' : '' }}>350 - Customs Status Information</option>
		   <option value="352" {{ $ediType->edt_transaction_set_name == '352' ? 'selected' : '' }}>352 - U.S. Customs Carrier General Order Status</option>
		   <option value="353" {{ $ediType->edt_transaction_set_name == '353' ? 'selected' : '' }}>353 - Customs Events Advisory Details</option>
		   <option value="354" {{ $ediType->edt_transaction_set_name == '354' ? 'selected' : '' }}>354 - U.S. Customs Automated Manifest Archive Status</option>
		   <option value="355" {{ $ediType->edt_transaction_set_name == '355' ? 'selected' : '' }}>355 - U.S. Customs Acceptance/Rejection</option>
		   <option value="356" {{ $ediType->edt_transaction_set_name == '356' ? 'selected' : '' }}>356 - U.S. Customs Permit to Transfer Request</option>
		   <option value="357" {{ $ediType->edt_transaction_set_name == '357' ? 'selected' : '' }}>357 - U.S. Customs In-Bond Information</option>
		   <option value="358" {{ $ediType->edt_transaction_set_name == '358' ? 'selected' : '' }}>358 - Customs Consist Information</option>
		   <option value="361" {{ $ediType->edt_transaction_set_name == '361' ? 'selected' : '' }}>361 - Carrier Interchange Agreement (Ocean)</option>
		   <option value="362" {{ $ediType->edt_transaction_set_name == '362' ? 'selected' : '' }}>362 - Cargo Insurance Advice of Shipment</option>
		   <option value="404" {{ $ediType->edt_transaction_set_name == '404' ? 'selected' : '' }}>404 - Rail Carrier Shipment Information</option>
		   <option value="410" {{ $ediType->edt_transaction_set_name == '410' ? 'selected' : '' }}>410 - Rail Carrier Freight Details and Invoice</option>
		   <option value="414" {{ $ediType->edt_transaction_set_name == '414' ? 'selected' : '' }}>414 - Rail Carhire Settlements</option>
		   <option value="417" {{ $ediType->edt_transaction_set_name == '417' ? 'selected' : '' }}>417 - Rail Carrier Waybill Interchange</option>
		   <option value="418" {{ $ediType->edt_transaction_set_name == '418' ? 'selected' : '' }}>418 - Rail Advance Interchange Consist</option>
		   <option value="419" {{ $ediType->edt_transaction_set_name == '419' ? 'selected' : '' }}>419 - Advance Car Disposition</option>
		   <option value="420" {{ $ediType->edt_transaction_set_name == '420' ? 'selected' : '' }}>420 - Car Handling Information</option>
		   <option value="421" {{ $ediType->edt_transaction_set_name == '421' ? 'selected' : '' }}>421 - Estimated Time of Arrival and Car Scheduling</option>
		   <option value="422" {{ $ediType->edt_transaction_set_name == '422' ? 'selected' : '' }}>422 - Shippers Car Order</option>
		   <option value="423" {{ $ediType->edt_transaction_set_name == '423' ? 'selected' : '' }}>423 - Rail Industrial Switch List</option>
		   <option value="425" {{ $ediType->edt_transaction_set_name == '425' ? 'selected' : '' }}>425 - Rail Waybill Request</option>
		   <option value="426" {{ $ediType->edt_transaction_set_name == '426' ? 'selected' : '' }}>426 - Rail Revenue Waybill</option>
		   <option value="429" {{ $ediType->edt_transaction_set_name == '429' ? 'selected' : '' }}>429 - Railroad Retirement Activity</option>
		   <option value="431" {{ $ediType->edt_transaction_set_name == '431' ? 'selected' : '' }}>431 - Railroad Station Master File</option>
		   <option value="432" {{ $ediType->edt_transaction_set_name == '432' ? 'selected' : '' }}>432 - Rail Deprescription</option>
		   <option value="433" {{ $ediType->edt_transaction_set_name == '433' ? 'selected' : '' }}>433 - Railroad Reciprocal Switch File</option>
		   <option value="434" {{ $ediType->edt_transaction_set_name == '434' ? 'selected' : '' }}>434 - Railroad Mark Register Update Activity</option>
		   <option value="435" {{ $ediType->edt_transaction_set_name == '435' ? 'selected' : '' }}>435 - Standard Transportation Commodity Code Master</option>
		   <option value="436" {{ $ediType->edt_transaction_set_name == '436' ? 'selected' : '' }}>436 - Locomotive Information</option>
		   <option value="437" {{ $ediType->edt_transaction_set_name == '437' ? 'selected' : '' }}>437 - Railroad Junctions and Interchanges Activity</option>
		   <option value="440" {{ $ediType->edt_transaction_set_name == '440' ? 'selected' : '' }}>440 - Shipment Weights</option>
		   <option value="451" {{ $ediType->edt_transaction_set_name == '451' ? 'selected' : '' }}>451 - Railroad Event Report</option>
		   <option value="452" {{ $ediType->edt_transaction_set_name == '452' ? 'selected' : '' }}>452 - Railroad Problem Log Inquiry or Advice</option>
		   <option value="453" {{ $ediType->edt_transaction_set_name == '453' ? 'selected' : '' }}>453 - Railroad Service Commitment Advice</option>
		   <option value="455" {{ $ediType->edt_transaction_set_name == '455' ? 'selected' : '' }}>455 - Railroad Parameter Trace Registration</option>
		   <option value="456" {{ $ediType->edt_transaction_set_name == '456' ? 'selected' : '' }}>456 - Railroad Equipment Inquiry or Advice</option>
		   <option value="460" {{ $ediType->edt_transaction_set_name == '460' ? 'selected' : '' }}>460 - Railroad Price Distribution Request or Response</option>
		   <option value="463" {{ $ediType->edt_transaction_set_name == '463' ? 'selected' : '' }}>463 - Rail Rate Reply</option>
		   <option value="466" {{ $ediType->edt_transaction_set_name == '466' ? 'selected' : '' }}>466 - Rate Request</option>
		   <option value="468" {{ $ediType->edt_transaction_set_name == '468' ? 'selected' : '' }}>468 - Rate Docket Journal Log</option>
		   <option value="470" {{ $ediType->edt_transaction_set_name == '470' ? 'selected' : '' }}>470 - Railroad Clearance</option>
		   <option value="475" {{ $ediType->edt_transaction_set_name == '475' ? 'selected' : '' }}>475 - Rail Route File Maintenance</option>
		   <option value="485" {{ $ediType->edt_transaction_set_name == '485' ? 'selected' : '' }}>485 - Ratemaking Action</option>
		   <option value="486" {{ $ediType->edt_transaction_set_name == '486' ? 'selected' : '' }}>486 - Rate Docket Expiration</option>
		   <option value="490" {{ $ediType->edt_transaction_set_name == '490' ? 'selected' : '' }}>490 - Rate Group Definition</option>
		   <option value="492" {{ $ediType->edt_transaction_set_name == '492' ? 'selected' : '' }}>492 - Miscellaneous Rates</option>
		   <option value="494" {{ $ediType->edt_transaction_set_name == '494' ? 'selected' : '' }}>494 - Rail Scale Rates</option>
		   <option value="500" {{ $ediType->edt_transaction_set_name == '500' ? 'selected' : '' }}>500 - Medical Event Reporting</option>
		   <option value="501" {{ $ediType->edt_transaction_set_name == '501' ? 'selected' : '' }}>501 - Vendor Performance Review</option>
		   <option value="503" {{ $ediType->edt_transaction_set_name == '503' ? 'selected' : '' }}>503 - Pricing History</option>
		   <option value="504" {{ $ediType->edt_transaction_set_name == '504' ? 'selected' : '' }}>504 - Clauses and Provisions</option>
		   <option value="511" {{ $ediType->edt_transaction_set_name == '511' ? 'selected' : '' }}>511 - Requisition</option>
		   <option value="517" {{ $ediType->edt_transaction_set_name == '517' ? 'selected' : '' }}>517 - Material Obligation Validation</option>
		   <option value="521" {{ $ediType->edt_transaction_set_name == '521' ? 'selected' : '' }}>521 - Income or Asset Offset</option>
		   <option value="527" {{ $ediType->edt_transaction_set_name == '527' ? 'selected' : '' }}>527 - Material Due-In and Receipt</option>
		   <option value="536" {{ $ediType->edt_transaction_set_name == '536' ? 'selected' : '' }}>536 - Logistics Reassignment</option>
		   <option value="540" {{ $ediType->edt_transaction_set_name == '540' ? 'selected' : '' }}>540 - Notice of Employment Status</option>
		   <option value="561" {{ $ediType->edt_transaction_set_name == '561' ? 'selected' : '' }}>561 - Contract Abstract</option>
		   <option value="567" {{ $ediType->edt_transaction_set_name == '567' ? 'selected' : '' }}>567 - Contract Completion Status</option>
		   <option value="568" {{ $ediType->edt_transaction_set_name == '568' ? 'selected' : '' }}>568 - Contract Payment Management Report</option>
		   <option value="601" {{ $ediType->edt_transaction_set_name == '601' ? 'selected' : '' }}>601 - U.S. Customs Export Shipment Information</option>
		   <option value="602" {{ $ediType->edt_transaction_set_name == '602' ? 'selected' : '' }}>602 - Transportation Services Tender</option>
		   <option value="620" {{ $ediType->edt_transaction_set_name == '620' ? 'selected' : '' }}>620 - Excavation Communication</option>
		   <option value="625" {{ $ediType->edt_transaction_set_name == '625' ? 'selected' : '' }}>625 - Well Information</option>
		   <option value="650" {{ $ediType->edt_transaction_set_name == '650' ? 'selected' : '' }}>650 - Maintenance Service Order</option>
		   <option value="715" {{ $ediType->edt_transaction_set_name == '715' ? 'selected' : '' }}>715 - Intermodal Group Loading Plan</option>
		   <option value="805" {{ $ediType->edt_transaction_set_name == '805' ? 'selected' : '' }}>805 - Contract Pricing Proposal</option>
		   <option value="806" {{ $ediType->edt_transaction_set_name == '806' ? 'selected' : '' }}>806 - Project Schedule Reporting</option>
		   <option value="810" {{ $ediType->edt_transaction_set_name == '810' ? 'selected' : '' }}>810 - Invoice</option>
		   <option value="811" {{ $ediType->edt_transaction_set_name == '811' ? 'selected' : '' }}>811 - Consolidated Service Invoice/Statement</option>
		   <option value="812" {{ $ediType->edt_transaction_set_name == '812' ? 'selected' : '' }}>812 - Credit/Debit Adjustment</option>
		   <option value="813" {{ $ediType->edt_transaction_set_name == '813' ? 'selected' : '' }}>813 - Electronic Filing of Tax Return Data</option>
		   <option value="814" {{ $ediType->edt_transaction_set_name == '814' ? 'selected' : '' }}>814 - General Request</option>
		   <option value="815" {{ $ediType->edt_transaction_set_name == '815' ? 'selected' : '' }}>815 - Cryptographic Service Message</option>
		   <option value="816" {{ $ediType->edt_transaction_set_name == '816' ? 'selected' : '' }}>816 - Organizational Relationships</option>
		   <option value="818" {{ $ediType->edt_transaction_set_name == '818' ? 'selected' : '' }}>818 - Commission Sales Report</option>
		   <option value="819" {{ $ediType->edt_transaction_set_name == '819' ? 'selected' : '' }}>819 - Operating Expense Statement</option>
		   <option value="820" {{ $ediType->edt_transaction_set_name == '820' ? 'selected' : '' }}>820 - Payment Order/Remittance Advice</option>
		   <option value="821" {{ $ediType->edt_transaction_set_name == '821' ? 'selected' : '' }}>821 - Financial Information Reporting</option>
		   <option value="822" {{ $ediType->edt_transaction_set_name == '822' ? 'selected' : '' }}>822 - Account Analysis</option>
		   <option value="823" {{ $ediType->edt_transaction_set_name == '823' ? 'selected' : '' }}>823 - Lockbox</option>
		   <option value="824" {{ $ediType->edt_transaction_set_name == '824' ? 'selected' : '' }}>824 - Application Advice</option>
		   <option value="826" {{ $ediType->edt_transaction_set_name == '826' ? 'selected' : '' }}>826 - Tax Information Exchange</option>
		   <option value="827" {{ $ediType->edt_transaction_set_name == '827' ? 'selected' : '' }}>827 - Financial Return Notice</option>
		   <option value="828" {{ $ediType->edt_transaction_set_name == '828' ? 'selected' : '' }}>828 - Debit Authorization</option>
		   <option value="829" {{ $ediType->edt_transaction_set_name == '829' ? 'selected' : '' }}>829 - Payment Cancellation Request</option>
		   <option value="830" {{ $ediType->edt_transaction_set_name == '830' ? 'selected' : '' }}>830 - Planning Schedule with Release Capability</option>
		   <option value="831" {{ $ediType->edt_transaction_set_name == '831' ? 'selected' : '' }}>831 - Application Control Totals</option>
		   <option value="832" {{ $ediType->edt_transaction_set_name == '832' ? 'selected' : '' }}>832 - Price/Sales Catalog</option>
		   <option value="833" {{ $ediType->edt_transaction_set_name == '833' ? 'selected' : '' }}>833 - Mortgage Credit Report Order</option>
		   <option value="834" {{ $ediType->edt_transaction_set_name == '834' ? 'selected' : '' }}>834 - Benefit Enrollment and Maintenance</option>
		   <option value="835" {{ $ediType->edt_transaction_set_name == '835' ? 'selected' : '' }}>835 - Health Care Claim Payment/Advice</option>
		   <option value="836" {{ $ediType->edt_transaction_set_name == '836' ? 'selected' : '' }}>836 - Procurement Notices</option>
		   <option value="837" {{ $ediType->edt_transaction_set_name == '837' ? 'selected' : '' }}>837 - Health Care Claim</option>
		   <option value="838" {{ $ediType->edt_transaction_set_name == '838' ? 'selected' : '' }}>838 - Trading Partner Profile</option>
		   <option value="839" {{ $ediType->edt_transaction_set_name == '839' ? 'selected' : '' }}>839 - Project Cost Reporting</option>
		   <option value="840" {{ $ediType->edt_transaction_set_name == '840' ? 'selected' : '' }}>840 - Request for Quotation</option>
		   <option value="841" {{ $ediType->edt_transaction_set_name == '841' ? 'selected' : '' }}>841 - Specifications/Technical Information</option>
		   <option value="842" {{ $ediType->edt_transaction_set_name == '842' ? 'selected' : '' }}>842 - Nonconformance Report</option>
		   <option value="843" {{ $ediType->edt_transaction_set_name == '843' ? 'selected' : '' }}>843 - Response to Request for Quotation</option>
		   <option value="844" {{ $ediType->edt_transaction_set_name == '844' ? 'selected' : '' }}>844 - Product Transfer Account Adjustment</option>
		   <option value="845" {{ $ediType->edt_transaction_set_name == '845' ? 'selected' : '' }}>845 - Price Authorization Acknowledgement/Status</option>
		   <option value="846" {{ $ediType->edt_transaction_set_name == '846' ? 'selected' : '' }}>846 - Inventory Inquiry/Advice</option>
		   <option value="847" {{ $ediType->edt_transaction_set_name == '847' ? 'selected' : '' }}>847 - Material Claim</option>
		   <option value="848" {{ $ediType->edt_transaction_set_name == '848' ? 'selected' : '' }}>848 - Material Safety Data Sheet</option>
		   <option value="849" {{ $ediType->edt_transaction_set_name == '849' ? 'selected' : '' }}>849 - Response to Product Transfer Account Adjustment</option>
		   <option value="850" {{ $ediType->edt_transaction_set_name == '850' ? 'selected' : '' }}>850 - Purchase Order</option>
		   <option value="851" {{ $ediType->edt_transaction_set_name == '851' ? 'selected' : '' }}>851 - Asset Schedule</option>
		   <option value="852" {{ $ediType->edt_transaction_set_name == '852' ? 'selected' : '' }}>852 - Product Activity Data</option>
		   <option value="853" {{ $ediType->edt_transaction_set_name == '853' ? 'selected' : '' }}>853 - Routing and Carrier Instruction</option>
		   <option value="854" {{ $ediType->edt_transaction_set_name == '854' ? 'selected' : '' }}>854 - Shipment Delivery Discrepancy Information</option>
		   <option value="855" {{ $ediType->edt_transaction_set_name == '855' ? 'selected' : '' }}>855 - Purchase Order Acknowledgement</option>
		   <option value="856" {{ $ediType->edt_transaction_set_name == '856' ? 'selected' : '' }}>856 - Ship Notice/Manifest</option>
		   <option value="857" {{ $ediType->edt_transaction_set_name == '857' ? 'selected' : '' }}>857 - Shipment and Billing Notice</option>
		   <option value="858" {{ $ediType->edt_transaction_set_name == '858' ? 'selected' : '' }}>858 - Shipment Information</option>
		   <option value="859" {{ $ediType->edt_transaction_set_name == '859' ? 'selected' : '' }}>859 - Freight Invoice</option>
		   <option value="860" {{ $ediType->edt_transaction_set_name == '860' ? 'selected' : '' }}>860 - Purchase Order Change Request - Buyer Initiated</option>
		   <option value="861" {{ $ediType->edt_transaction_set_name == '861' ? 'selected' : '' }}>861 - Receiving Advice/Acceptance Certificate</option>
		   <option value="862" {{ $ediType->edt_transaction_set_name == '862' ? 'selected' : '' }}>862 - Shipping Schedule</option>
		   <option value="863" {{ $ediType->edt_transaction_set_name == '863' ? 'selected' : '' }}>863 - Report of Test Results</option>
		   <option value="864" {{ $ediType->edt_transaction_set_name == '864' ? 'selected' : '' }}>864 - Text Message</option>
		   <option value="865" {{ $ediType->edt_transaction_set_name == '865' ? 'selected' : '' }}>865 - Purchase Order Change Acknowledgement/Request -Seller Initiated</option>
		   <option value="866" {{ $ediType->edt_transaction_set_name == '866' ? 'selected' : '' }}>866 - Production Sequence</option>
		   <option value="867" {{ $ediType->edt_transaction_set_name == '867' ? 'selected' : '' }}>867 - Product Transfer and Resale Report</option>
		   <option value="868" {{ $ediType->edt_transaction_set_name == '868' ? 'selected' : '' }}>868 - Electronic Form Structure</option>
		   <option value="869" {{ $ediType->edt_transaction_set_name == '869' ? 'selected' : '' }}>869 - Order Status Inquiry</option>
		   <option value="870" {{ $ediType->edt_transaction_set_name == '870' ? 'selected' : '' }}>870 - Order Status Report</option>
		   <option value="871" {{ $ediType->edt_transaction_set_name == '871' ? 'selected' : '' }}>871 - Component Parts Content</option>
		   <option value="872" {{ $ediType->edt_transaction_set_name == '872' ? 'selected' : '' }}>872 - Residential Mortgage Insurance Application</option>
		   <option value="875" {{ $ediType->edt_transaction_set_name == '875' ? 'selected' : '' }}>875 - Grocery Products Purchase Order</option>
		   <option value="876" {{ $ediType->edt_transaction_set_name == '876' ? 'selected' : '' }}>876 - Grocery Products Purchase Order Change</option>
		   <option value="877" {{ $ediType->edt_transaction_set_name == '877' ? 'selected' : '' }}>877 - Manufacturer Coupon Family Code Structure</option>
		   <option value="878" {{ $ediType->edt_transaction_set_name == '878' ? 'selected' : '' }}>878 - Product Authorization/De-authorization</option>
		   <option value="879" {{ $ediType->edt_transaction_set_name == '879' ? 'selected' : '' }}>879 - Price Information</option>
		   <option value="880" {{ $ediType->edt_transaction_set_name == '880' ? 'selected' : '' }}>880 - Grocery Products Invoice</option>
		   <option value="881" {{ $ediType->edt_transaction_set_name == '881' ? 'selected' : '' }}>881 - Manufacturer Coupon Redemption Detail</option>
		   <option value="882" {{ $ediType->edt_transaction_set_name == '882' ? 'selected' : '' }}>882 - Direct Store Delivery Summary Information</option>
		   <option value="883" {{ $ediType->edt_transaction_set_name == '883' ? 'selected' : '' }}>883 - Market Development Fund Allocation</option>
		   <option value="884" {{ $ediType->edt_transaction_set_name == '884' ? 'selected' : '' }}>884 - Market Development Fund Settlement</option>
		   <option value="885" {{ $ediType->edt_transaction_set_name == '885' ? 'selected' : '' }}>885 - Retail Account Characteristics</option>
		   <option value="886" {{ $ediType->edt_transaction_set_name == '886' ? 'selected' : '' }}>886 - Customer Call Reporting</option>
		   <option value="887" {{ $ediType->edt_transaction_set_name == '887' ? 'selected' : '' }}>887 - Coupon Notification</option>
		   <option value="888" {{ $ediType->edt_transaction_set_name == '888' ? 'selected' : '' }}>888 - Item Maintenance</option>
		   <option value="889" {{ $ediType->edt_transaction_set_name == '889' ? 'selected' : '' }}>889 - Promotion Announcement</option>
		   <option value="891" {{ $ediType->edt_transaction_set_name == '891' ? 'selected' : '' }}>891 - Deduction Research Report</option>
		   <option value="893" {{ $ediType->edt_transaction_set_name == '893' ? 'selected' : '' }}>893 - Item Information Request</option>
		   <option value="894" {{ $ediType->edt_transaction_set_name == '894' ? 'selected' : '' }}>894 - Delivery/Return Base Record</option>
		   <option value="895" {{ $ediType->edt_transaction_set_name == '895' ? 'selected' : '' }}>895 - Delivery/Return Acknowledgement or Adjustment</option>
		   <option value="896" {{ $ediType->edt_transaction_set_name == '896' ? 'selected' : '' }}>896 - Product Dimension Maintenance</option>
		   <option value="920" {{ $ediType->edt_transaction_set_name == '920' ? 'selected' : '' }}>920 - Loss or Damage Claim - General Commodities</option>
		   <option value="924" {{ $ediType->edt_transaction_set_name == '924' ? 'selected' : '' }}>924 - Loss or Damage Claim - Motor Vehicle</option>
		   <option value="925" {{ $ediType->edt_transaction_set_name == '925' ? 'selected' : '' }}>925 - Claim Tracer</option>
		   <option value="926" {{ $ediType->edt_transaction_set_name == '926' ? 'selected' : '' }}>926 - Claim Status Report and Tracer Reply</option>
		   <option value="928" {{ $ediType->edt_transaction_set_name == '928' ? 'selected' : '' }}>928 - Automotive Inspection Detail</option>
		   <option value="940" {{ $ediType->edt_transaction_set_name == '940' ? 'selected' : '' }}>940 - Warehouse Shipping Order</option>
		   <option value="943" {{ $ediType->edt_transaction_set_name == '943' ? 'selected' : '' }}>943 - Warehouse Stock Transfer Shipment Advice</option>
		   <option value="944" {{ $ediType->edt_transaction_set_name == '944' ? 'selected' : '' }}>944 - Warehouse Stock Transfer Receipt Advice</option>
		   <option value="945" {{ $ediType->edt_transaction_set_name == '945' ? 'selected' : '' }}>945 - Warehouse Shipping Advice</option>
		   <option value="947" {{ $ediType->edt_transaction_set_name == '947' ? 'selected' : '' }}>947 - Warehouse Inventory Adjustment Advice</option>
		   <option value="980" {{ $ediType->edt_transaction_set_name == '980' ? 'selected' : '' }}>980 - Functional Group Totals</option>
		   <option value="990" {{ $ediType->edt_transaction_set_name == '990' ? 'selected' : '' }}>990 - Response to a Load Tender</option>
		   <option value="993" {{ $ediType->edt_transaction_set_name == '993' ? 'selected' : '' }}>993 - Secured Receipt or Acknowledgement</option>
		   <option value="996" {{ $ediType->edt_transaction_set_name == '996' ? 'selected' : '' }}>996 - File Transfer</option>
		   <option value="997" {{ $ediType->edt_transaction_set_name == '997' ? 'selected' : '' }}>997 - Functional Acknowledgement</option>
		   <option value="998" {{ $ediType->edt_transaction_set_name == '998' ? 'selected' : '' }}>998 - Set Cancellation</option>
		   <option value="999" {{ $ediType->edt_transaction_set_name == '999' ? 'selected' : '' }}>999 - Implementation Acknowledgement</option>
		</select>
	</div>

   <div class="mb-3">
    <label for="edt_is_incoming" class="form-label">Read or Send</label>
    <select id="edt_is_incoming" class="form-select" aria-label="Read or Send">
    	<option value="1" {{ $ediType->edt_is_incoming == 1 ? 'selected' : '' }}>Read</option>
    	<option value="0" {{ $ediType->edt_is_incoming == 0 ? 'selected' : '' }}>Send</option>
    </select>
   </div>

	<div class="mb-3">
   		<label for="edt_control_number" class="form-label">Control Number</label>
   		<input type="input" class="form-control" id="edt_control_number" aria-describedby="edtControlNumberHelp" value="{{ $ediType->edt_control_number }}">
		<div id="edtControlNumberHelp" class="form-text">Only change the Control Number if you know what you are doing</div>
	</div>
	   
	<div class="mb-3 form-check">
  		<input class="form-check-input" type="checkbox" value="{{ $ediType->edt_enabled }}" id="edt_enabled" {{ $ediType->edt_enabled == '1' ? 'checked' : '' }}>
	   <label class="form-check-label" for="edt_enabled">Enabled</label>
		<div id="edtEnabledHelp" class="form-text">If this transaction set is automated, checking this box will automate it</div>	   
	</div>	  
	
	<div class="mb-3 form-check">
  		<input class="form-check-input" type="checkbox" value="{{ $ediType->edt_manual_create }}" id="edt_manual_create" {{ $ediType->edt_manual_create == '1' ? 'checked' : '' }}>
	   <label class="form-check-label" for="edt_manual_create">Manual Create</label>
		<div id="edtManualHelp" class="form-text">If this is checked, you will be able to manually create EDI files in the dashboard</div>	   
	</div>	  

	<div class="mb-3">
		<div class="row">
			<div class="col-6">Before Processing</div>
			<div class="col-6">
				@if (empty($ediType->edt_before_process_object) )
			   	@php( $beforeProcessObject = Bgies\EdiLaravel\Functions\FileFunctions::getFileNamesFromPackageDirectory('FileHandling')   )
    				<select id="new-before-process-select" class="form-select" aria-label="Choose Before Process Object" hidden>
    				@foreach($beforeProcessObject as $curFile)
	    				<option value="{{ substr($curFile, 0, strlen($curFile) - 4) }}" >{{ substr($curFile, 0, strlen($curFile) - 4) }}</option>    				
    				@endforeach
    				</select>
			   	<button id="before_process_button" type="button" class="btn btn-primary create-object-button">Choose Object</button>
				@else
					<a href="/edilaravel/editype/field/{{ $ediType->id . '/edt_before_process_object'  }}/edit" >
						Before Processing Options
					</a>
				@endif
			
			</div>
		</div>		   
	</div>  
	
	<div class="mb-3">
   		<label for="edt_file_directory" class="form-label">EDI File Directory</label>
   		<input type="input" class="form-control" id="edt_file_directory" aria-describedby="edtFileDirectoryHelp" value="{{ $ediType->edt_file_directory }}">
		<div id="edtFileDirectoryHelp" class="form-text">For incoming files, this should be the directory the (FTP, FTPS, AS2) server puts them in. For outgoing files, it will be the directory to put the file in so it will be sent</div>
	</div>
	
	<div class="mb-3">
		<div class="row">
		<div class="col-6">EDI Options</div>
		<div class="col-6">
			<a href="/edilaravel/editype/field/{{ $ediType->id . '/edt_edi_object'  }}/edit" >EDI Options</a>
		</div>
		</div>
	</div>  
	
	<div class="mb-3">
		<div class="row">
			<div class="col-6">After Processing</div>
			<div class="col-6">
				<a href="/edilaravel/editype/field/{{ $ediType->id . '/edt_after_process_object'  }}/edit" >After Processing</a>
			</div>
		</div>
	</div>  

	<div class="mb-3 form-check">
  		<input class="form-check-input" type="checkbox" value="{{ $ediType->edt_alert_if_not_acknowledged }}" id="edt_alert_if_not_acknowledged" {{ $ediType->edt_alert_if_not_acknowledged == '1' ? 'checked' : '' }}>
	   <label class="form-check-label" for="edt_alert_if_not_acknowledged">Alert if Not Acknowledged</label>
	</div>	  
	
	<div class="mb-3">
		<div class="row">
		<div class="col-6">Alert Options</div>
		<div class="col-6">
			@if (empty($ediType->edt_alert_object) )
			   		<p>edt_alert_object is Null</p>
			@else  
				<a href="/edilaravel/editype/field/{{ $ediType->id . '/edt_alert_object'  }}/edit" >Alert Options</a>
			@endif
		</div>
		</div>
	</div>  
	 
	<div class="mb-3">
		<div class="row">
		<div class="col-6">File Drop Options</div>
		<div class="col-6">
		   @if (empty($ediType->edt_file_drop) )
		   		<p>edt_file_drop is Null</p>
		   	@else  
				<a href="/edilaravel/editype/field/{{ $ediType->id . '/edt_file_drop'  }}/edit" >File Drop Options</a>
			@endif
		</div>
		</div>
	</div>  
	 
	<div class="mb-3">
		<div class="row">
			<div class="col-6">Transmission Options</div>
			<div class="col-6">
				 @if (empty($ediType->edt_transmission_object) )
			   		<p>edt_transmission_object is Null</p>
			   	@else  
					<a href="/edilaravel/editype/field/{{ $ediType->id . '/edt_transmission_object'  }}/edit" >Transmission Object</a>
				@endif
			</div>
		</div>
	</div>  
	 
	<div class="mb-3">
   		<label for="interchange_sender_id" class="form-label">Interchange Sender ID</label>
   		<input type="input" class="form-control" id="interchange_sender_id" aria-describedby="InterchangeSenderIdHelp" value="{{ $ediType->interchange_sender_id }}">
		<div id="InterchangeSenderIdHelp" class="form-text">If you are sending this file to your trading partner this should be your interchange ID, if receiving this file, this should be your trading partner's interchange ID</div>
	</div>
	 
	<div class="mb-3">
   		<label for="interchange_receiver_id" class="form-label">Interchange Receiver ID</label>
   		<input type="input" class="form-control" id="interchange_receiver_id" aria-describedby="InterchangeReceiverIdHelp" value="{{ $ediType->interchange_receiver_id }}">
		<div id="InterchangeReceiverIdHelp" class="form-text">If you are sending this file to your trading partner this should be their interchange ID, if receiving this file, this should be your your interchange ID</div>
	</div>
	 
	<div class="mb-3">
   		<label for="application_sender_code" class="form-label">Application Sender Code</label>
   		<input type="input" class="form-control" id="application_sender_code" aria-describedby="ApplicationSenderCodeHelp" value="{{ $ediType->application_sender_code }}">
		<div id="ApplicationSenderCodeHelp" class="form-text">If you are sending this file to your trading partner this should be your Application Code, if receiving this file, this should be your trading partner's Application Code</div>
	</div>
	 
	<div class="mb-3">
   		<label for="application_receiver_code" class="form-label">Application Receiver Code</label>
   		<input type="input" class="form-control" id="application_receiver_code" aria-describedby="ApplicationReceiverCodeHelp" value="{{ $ediType->application_receiver_code }}">
		<div id="ApplicationReceiverCodeHelp" class="form-text">If you are sending this file to your trading partner this should be your Application Code, if receiving this file, this should be your trading partner's interchange ID</div>
	</div>
	 
	<div class="mb-3 row">
   		<label for="staticCreatedAt" class="col-sm-3 col-form-label disabled">Created At</label>
		<div class="col-sm-9">
      		<input type="text" readonly class="form-control-plaintext disabled" id="staticCreatedAt" value="{{ $ediType->created_at }}">
    	</div>
	</div>   
	
	<div class="mb-3 row">
   		<label for="staticUpdatedAt" class="col-sm-3 col-form-label disabled">Updated At</label>
		<div class="col-sm-9">
      		<input type="text" readonly class="form-control-plaintext disabled" id="staticUpdatedAt" value="{{ $ediType->updated_at }}">
    	</div>
	</div>   	   

  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">I understand that bad data may stop the entire EDI system</label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>   


<br />
<br />
<br />


	

<!--     
   <div class="container edi-grid edi-grid-bg column-gap: 10px">
   		@foreach($fields as $curField => $curFieldValue)   
   			<div class="row edi-grid-name">
   				<div class="col-6">
   					{{ $curField }}   			
   				</div>
  					
  					@php( $fieldType = \DB::getSchemaBuilder()->getColumnType('edi_types', $curField) )
   					@if(in_array($curField, ['edt_before_process_object', 'edt_edi_object',
   					   'edt_after_process_object', 'edt_alert_object', 'edt_file_drop', 'edt_transmission_object']))
   					   <div class="col-6 edi-object">
   						<div class="edi-field-name">{{ $curField }}</div>
	
				   		@php( $serObject = unserialize($curFieldValue) )
   				      
   						<div>serObject : {{{ is_null($serObject) ? 'null' : print_r($serObject, true)    }}} </div>
   						<div>Field Type: {{ $fieldType }}</div>	
   				
   					@else
   						<div class="col-6 edi-grid-value">
   							
   							{{ $curFieldValue }}
					@endif
					   						   			
	   				</div>
   					
   			</div>
   
   		@endforeach    
   </div>
 -->   
   
<div class="modal" id="edi-new-object-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="edi-new-object-title" class="modal-title">Create Object</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <p class="edi-new-object-body">
           	<label id="new-object-select-label" for="new-object-select" class="form-label">Choose Object</label>
    				<select id="new-object-select" class="form-select" aria-label="Choose Object to Create">
    					
    				</select>
          </p>
          <p class="edi-new-object-body">Note - clicking the "Create New Object" button will submit all your current changes.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="cancelNewObject()" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="createNewObject()">Create New Object</button>
      </div>
    </div>
  </div>
</div>
   
   
   
   <script>
   
   
   	// Add click event to ALL create object buttons  - Inline JS
	var buttons = document.querySelectorAll('.create-object-button');
	Array.prototype.slice.call(buttons)
   	 .forEach(function (button) {
			button.addEventListener('click', function (event) {

				let modalSelect1 = document.getElementById("new-object-select"); 
				switch (button.id) {
					case 'before_process_button': 
					   let modalLabel = document.getElementById("new-object-select-label");
					   modalLabel.innerHTML = "Choose Object for Before Process Options";
						let modalSelect2 = document.getElementById("new-before-process-select");
						modalSelect1.innerHTML = modalSelect2.innerHTML + modalSelect1.innerHTML;
					break;
				
				
				
				}
				let myModal = new bootstrap.Modal(document.getElementById('edi-new-object-modal'));					
				myModal.show();
	
			});
		});
			
	 function cancelNewType() {
		myModal.dismiss();
	 }
	 
	 function createNewObject() {

	 	let dropdownList = document.getElementById("new-object-select");
	 	let dropdownValue = dropdownList.options[dropdownList.selectedIndex].text;
	 	let idElement = document.getElementById("staticId");
	 	let ediTypeId = idElement.value;
	 	
	 	
	 	alert('ediTypeId: ' + ediTypeId);	 	
	 	
	 	
	 }
   
   </script>
    
@endsection

