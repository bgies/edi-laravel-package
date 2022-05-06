<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EDIGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('edi_groups')->truncate();
        \DB::table('edi_groups')->insert([
            [
                'id' => 1,
                'edg_group_name' => 'Unknown',
                'edg_description' => ''
            ],
            [
                'id' => 2,
                'edg_group_name' => 'ExcelFile',
                'edg_description' => ''
            ],
            [
                'id' => 3,
                'edg_group_name' => 'TextFile',
                'edg_description' => ''
            ],
            [
                'id' => 4,
                'edg_group_name' => 'DebitFile',
                'edg_description' => ''
            ],
            [
                'id' => 5,
                'edg_group_name' => 'Miscellaneous',
                'edg_description' => ''
            ],
            [ 'id' => 100, 'edg_group_name' => '100', 'edg_description' => 'Insurance Plan Description'],
            [ 'id' => 101, 'edg_group_name' => '101', 'edg_description' => 'Name and Address Lists'],
            [ 'id' => 102, 'edg_group_name' => '102', 'edg_description' => 'Associated Data'],
            [ 'id' => 103, 'edg_group_name' => '103', 'edg_description' => 'Abandoned Property Filings'],
            [ 'id' => 104, 'edg_group_name' => '104', 'edg_description' => 'Air Shipment Information'],
            [ 'id' => 105, 'edg_group_name' => '105', 'edg_description' => 'Business Entity Filings'],
            [ 'id' => 106, 'edg_group_name' => '106', 'edg_description' => 'Motor Carrier Rate Proposal'],
            [ 'id' => 107, 'edg_group_name' => '107', 'edg_description' => 'Request for Motor Carrier Rate Proposal'],
            [ 'id' => 108, 'edg_group_name' => '108', 'edg_description' => 'Response to a Motor Carrier Rate Proposal'],
            [ 'id' => 109, 'edg_group_name' => '109', 'edg_description' => 'Vessel Content Details'],
            [ 'id' => 110, 'edg_group_name' => '110', 'edg_description' => 'Air Freight Details and Invoice'],
            [ 'id' => 111, 'edg_group_name' => '111', 'edg_description' => 'Individual Insurance Policy and Client Information'],
            [ 'id' => 112, 'edg_group_name' => '112', 'edg_description' => 'Property Damage Report'],
            [ 'id' => 120, 'edg_group_name' => '120', 'edg_description' => 'Vehicle Shipping Order'],
            [ 'id' => 121, 'edg_group_name' => '121', 'edg_description' => 'Vehicle Service'],
            [ 'id' => 124, 'edg_group_name' => '124', 'edg_description' => 'Vehicle Damage'],
            [ 'id' => 125, 'edg_group_name' => '125', 'edg_description' => 'Multilevel Railcar Load Details'],
            [ 'id' => 126, 'edg_group_name' => '126', 'edg_description' => 'Vehicle Application Advice'],
            [ 'id' => 127, 'edg_group_name' => '127', 'edg_description' => 'Vehicle Baying Order'],
            [ 'id' => 128, 'edg_group_name' => '128', 'edg_description' => 'Dealer Information'],
            [ 'id' => 129, 'edg_group_name' => '129', 'edg_description' => 'Vehicle Carrier Rate Update'],
            [ 'id' => 130, 'edg_group_name' => '130', 'edg_description' => 'Student Educational Record (Transcript)'],
            [ 'id' => 131, 'edg_group_name' => '131', 'edg_description' => 'Student Educational Record (Transcript) Acknowledgement'],
            [ 'id' => 135, 'edg_group_name' => '135', 'edg_description' => 'Student Aid Origination Record'],
            [ 'id' => 138, 'edg_group_name' => '138', 'edg_description' => 'Education Testing Results Request and Report'],
            [ 'id' => 139, 'edg_group_name' => '139', 'edg_description' => 'Student Loan Guarantee Result'],
            [ 'id' => 140, 'edg_group_name' => '140', 'edg_description' => 'Product Registration'],
            [ 'id' => 141, 'edg_group_name' => '141', 'edg_description' => 'Product Service Claim Response'],
            [ 'id' => 142, 'edg_group_name' => '142', 'edg_description' => 'Product Service Claim'],
            [ 'id' => 143, 'edg_group_name' => '143', 'edg_description' => 'Product Service Notification'],
            [ 'id' => 144, 'edg_group_name' => '144', 'edg_description' => 'Student Loan Transfer and Status Verification'],
            [ 'id' => 146, 'edg_group_name' => '146', 'edg_description' => 'Request for Student Educational Record (Transcript)'],
            [ 'id' => 147, 'edg_group_name' => '147', 'edg_description' => 'Response to Request for Student Educational Record (Transcript)'],
            [ 'id' => 148, 'edg_group_name' => '148', 'edg_description' => 'Report of Injury'],
            [ 'id' => 149, 'edg_group_name' => '149', 'edg_description' => 'Notice of Tax Adjustment or Assessment'],
            [ 'id' => 150, 'edg_group_name' => '150', 'edg_description' => 'Tax Rate Notification'],
            [ 'id' => 151, 'edg_group_name' => '151', 'edg_description' => 'Electronic Filing of Tax Return Data Acknowledgement'],
            [ 'id' => 152, 'edg_group_name' => '152', 'edg_description' => 'Statistical Government Information'],
            [ 'id' => 153, 'edg_group_name' => '153', 'edg_description' => 'Unemployment Insurance Tax Claim or Charge Information'],
            [ 'id' => 154, 'edg_group_name' => '154', 'edg_description' => 'Secured Interest Filing'],
            [ 'id' => 155, 'edg_group_name' => '155', 'edg_description' => 'Business Credit Report'],
            [ 'id' => 157, 'edg_group_name' => '157', 'edg_description' => 'Notice of Power of Attorney'],
            [ 'id' => 159, 'edg_group_name' => '159', 'edg_description' => 'Motion Picture Booking Confirmation'],
            [ 'id' => 160, 'edg_group_name' => '160', 'edg_description' => 'Transportation Automatic Equipment Identification'],
            [ 'id' => 161, 'edg_group_name' => '161', 'edg_description' => 'Train Sheet'],
            [ 'id' => 163, 'edg_group_name' => '163', 'edg_description' => 'Transportation Appointment Schedule Information'],
            [ 'id' => 170, 'edg_group_name' => '170', 'edg_description' => 'Revenue Receipts Statement'],
            [ 'id' => 175, 'edg_group_name' => '175', 'edg_description' => 'Court and Law Enforcement Notice'],
            [ 'id' => 176, 'edg_group_name' => '176', 'edg_description' => 'Court Submission'],
            [ 'id' => 180, 'edg_group_name' => '180', 'edg_description' => 'Return Merchandise Authorization and Notification'],
            [ 'id' => 185, 'edg_group_name' => '185', 'edg_description' => 'Royalty Regulatory Report'],
            [ 'id' => 186, 'edg_group_name' => '186', 'edg_description' => 'Insurance Underwriting Requirements Reporting'],
            [ 'id' => 187, 'edg_group_name' => '187', 'edg_description' => 'Premium Audit Request and Return'],
            [ 'id' => 188, 'edg_group_name' => '188', 'edg_description' => 'Educational Course Inventory'],
            [ 'id' => 189, 'edg_group_name' => '189', 'edg_description' => 'Application for Admission to Educational Institutions'],
            [ 'id' => 190, 'edg_group_name' => '190', 'edg_description' => 'Student Enrollment Verification'],
            [ 'id' => 191, 'edg_group_name' => '191', 'edg_description' => 'Student Loan Pre-Claims and Claims'],
            [ 'id' => 194, 'edg_group_name' => '194', 'edg_description' => 'Grant or Assistance Application'],
            [ 'id' => 195, 'edg_group_name' => '195', 'edg_description' => 'Federal Communications Commission (FCC) License Application'],
            [ 'id' => 196, 'edg_group_name' => '196', 'edg_description' => 'Contractor Cost Data Reporting'],
            [ 'id' => 197, 'edg_group_name' => '197', 'edg_description' => 'Real Estate Title Evidence'],
            [ 'id' => 198, 'edg_group_name' => '198', 'edg_description' => 'Loan Verification Information'],
            [ 'id' => 199, 'edg_group_name' => '199', 'edg_description' => 'Real Estate Settlement Information'],
            [ 'id' => 200, 'edg_group_name' => '200', 'edg_description' => 'Mortgage Credit Report'],
            [ 'id' => 201, 'edg_group_name' => '201', 'edg_description' => 'Residential Loan Application'],
            [ 'id' => 202, 'edg_group_name' => '202', 'edg_description' => 'Secondary Mortgage Market Loan Delivery'],
            [ 'id' => 203, 'edg_group_name' => '203', 'edg_description' => 'Secondary Mortgage Market Investor Report'],
            [ 'id' => 204, 'edg_group_name' => '204', 'edg_description' => 'Motor Carrier Load Tender'],
            [ 'id' => 205, 'edg_group_name' => '205', 'edg_description' => 'Mortgage Note'],
            [ 'id' => 206, 'edg_group_name' => '206', 'edg_description' => 'Real Estate Inspection'],
            [ 'id' => 210, 'edg_group_name' => '210', 'edg_description' => 'Motor Carrier Freight Details and Invoice'],
            [ 'id' => 211, 'edg_group_name' => '211', 'edg_description' => 'Motor Carrier Bill of Lading'],
            [ 'id' => 212, 'edg_group_name' => '212', 'edg_description' => 'Motor Carrier Delivery Trailer Manifest'],
            [ 'id' => 213, 'edg_group_name' => '213', 'edg_description' => 'Motor Carrier Shipment Status Inquiry'],
            [ 'id' => 214, 'edg_group_name' => '214', 'edg_description' => 'Transportation Carrier Shipment Status Message'],
            [ 'id' => 215, 'edg_group_name' => '215', 'edg_description' => 'Motor Carrier Pick-up Manifest'],
            [ 'id' => 216, 'edg_group_name' => '216', 'edg_description' => 'Motor Carrier Shipment Pick-up Notification'],
            [ 'id' => 217, 'edg_group_name' => '217', 'edg_description' => 'Motor Carrier Loading and Route Guide'],
            [ 'id' => 218, 'edg_group_name' => '218', 'edg_description' => 'Motor Carrier Tariff Information'],
            [ 'id' => 219, 'edg_group_name' => '219', 'edg_description' => 'Logistics Service Request'],
            [ 'id' => 220, 'edg_group_name' => '220', 'edg_description' => 'Logistics Service Response'],
            [ 'id' => 222, 'edg_group_name' => '222', 'edg_description' => 'Cartage Work Assignment'],
            [ 'id' => 223, 'edg_group_name' => '223', 'edg_description' => 'Consolidators Freight Bill and Invoice'],
            [ 'id' => 224, 'edg_group_name' => '224', 'edg_description' => 'Motor Carrier Summary Freight Bill Manifest'],
            [ 'id' => 225, 'edg_group_name' => '225', 'edg_description' => 'Response to a Cartage Work Assignment'],
            [ 'id' => 240, 'edg_group_name' => '240', 'edg_description' => 'Motor Carrier Package Status'],
            [ 'id' => 242, 'edg_group_name' => '242', 'edg_description' => 'Data Status Tracking'],
            [ 'id' => 244, 'edg_group_name' => '244', 'edg_description' => 'Product Source Information'],
            [ 'id' => 248, 'edg_group_name' => '248', 'edg_description' => 'Account Assignment/Inquiry and Service/Status'],
            [ 'id' => 249, 'edg_group_name' => '249', 'edg_description' => 'Animal Toxicological Data'],
            [ 'id' => 250, 'edg_group_name' => '250', 'edg_description' => 'Purchase Order Shipment Management Document'],
            [ 'id' => 251, 'edg_group_name' => '251', 'edg_description' => 'Pricing Support'],
            [ 'id' => 252, 'edg_group_name' => '252', 'edg_description' => 'Insurance Producer Administration'],
            [ 'id' => 255, 'edg_group_name' => '255', 'edg_description' => 'Underwriting Information Services'],
            [ 'id' => 256, 'edg_group_name' => '256', 'edg_description' => 'Periodic Compensation'],
            [ 'id' => 260, 'edg_group_name' => '260', 'edg_description' => 'Application for Mortgage Insurance Benefits'],
            [ 'id' => 261, 'edg_group_name' => '261', 'edg_description' => 'Real Estate Information Request'],
            [ 'id' => 262, 'edg_group_name' => '262', 'edg_description' => 'Real Estate Information Report'],
            [ 'id' => 263, 'edg_group_name' => '263', 'edg_description' => 'Residential Mortgage Insurance Application Response'],
            [ 'id' => 264, 'edg_group_name' => '264', 'edg_description' => 'Mortgage Loan Default Status'],
            [ 'id' => 265, 'edg_group_name' => '265', 'edg_description' => 'Real Estate Title Insurance Services Order'],
            [ 'id' => 266, 'edg_group_name' => '266', 'edg_description' => 'Mortgage or Property Record Change Notification'],
            [ 'id' => 267, 'edg_group_name' => '267', 'edg_description' => 'Individual Life'],
            [ 'id' => 268, 'edg_group_name' => '268', 'edg_description' => 'Annuity Activity'],
            [ 'id' => 270, 'edg_group_name' => '270', 'edg_description' => 'Eligibility'],
            [ 'id' => 271, 'edg_group_name' => '271', 'edg_description' => 'Eligibility'],
            [ 'id' => 272, 'edg_group_name' => '272', 'edg_description' => 'Property and Casualty Loss Notification'],
            [ 'id' => 273, 'edg_group_name' => '273', 'edg_description' => 'Insurance/Annuity Application Status'],
            [ 'id' => 274, 'edg_group_name' => '274', 'edg_description' => 'Healthcare Provider Information'],
            [ 'id' => 275, 'edg_group_name' => '275', 'edg_description' => 'Patient Information'],
            [ 'id' => 276, 'edg_group_name' => '276', 'edg_description' => 'Health Care Claim Status Request'],
            [ 'id' => 277, 'edg_group_name' => '277', 'edg_description' => 'Health Care Claim Status Notification'],
            [ 'id' => 278, 'edg_group_name' => '278', 'edg_description' => 'Health Care Services Review Information'],
            [ 'id' => 280, 'edg_group_name' => '280', 'edg_description' => 'Voter Registration Information'],
            [ 'id' => 283, 'edg_group_name' => '283', 'edg_description' => 'Tax or Fee Exemption Certification'],
            [ 'id' => 284, 'edg_group_name' => '284', 'edg_description' => 'Commercial Vehicle Safety Reports'],
            [ 'id' => 285, 'edg_group_name' => '285', 'edg_description' => 'Commercial Vehicle Safety and Credentials Information Exchange'],
            [ 'id' => 286, 'edg_group_name' => '286', 'edg_description' => 'Commercial Vehicle Credentials'],
            [ 'id' => 288, 'edg_group_name' => '288', 'edg_description' => 'Wage Determination'],
            [ 'id' => 290, 'edg_group_name' => '290', 'edg_description' => 'Cooperative Advertising Agreements'],
            [ 'id' => 300, 'edg_group_name' => '300', 'edg_description' => 'Reservation (Booking Request) (Ocean)'],
            [ 'id' => 301, 'edg_group_name' => '301', 'edg_description' => 'Confirmation (Ocean)'],
            [ 'id' => 303, 'edg_group_name' => '303', 'edg_description' => 'Booking Cancellation (Ocean)'],
            [ 'id' => 304, 'edg_group_name' => '304', 'edg_description' => 'Shipping Instructions'],
            [ 'id' => 309, 'edg_group_name' => '309', 'edg_description' => 'Customs Manifest'],
            [ 'id' => 310, 'edg_group_name' => '310', 'edg_description' => 'Freight Receipt and Invoice (Ocean)'],
            [ 'id' => 311, 'edg_group_name' => '311', 'edg_description' => 'Canadian Customs Information'],
            [ 'id' => 312, 'edg_group_name' => '312', 'edg_description' => 'Arrival Notice (Ocean)'],
            [ 'id' => 313, 'edg_group_name' => '313', 'edg_description' => 'Shipment Status Inquiry (Ocean)'],
            [ 'id' => 315, 'edg_group_name' => '315', 'edg_description' => 'Status Details (Ocean)'],
            [ 'id' => 317, 'edg_group_name' => '317', 'edg_description' => 'Delivery/Pickup Order'],
            [ 'id' => 319, 'edg_group_name' => '319', 'edg_description' => 'Terminal Information'],
            [ 'id' => 322, 'edg_group_name' => '322', 'edg_description' => 'Terminal Operations and Intermodal Ramp Activity'],
            [ 'id' => 323, 'edg_group_name' => '323', 'edg_description' => 'Vessel Schedule and Itinerary (Ocean)'],
            [ 'id' => 324, 'edg_group_name' => '324', 'edg_description' => 'Vessel Stow Plan (Ocean)'],
            [ 'id' => 325, 'edg_group_name' => '325', 'edg_description' => 'Consolidation of Goods In Container'],
            [ 'id' => 326, 'edg_group_name' => '326', 'edg_description' => 'Consignment Summary List'],
            [ 'id' => 350, 'edg_group_name' => '350', 'edg_description' => 'Customs Status Information'],
            [ 'id' => 352, 'edg_group_name' => '352', 'edg_description' => 'U.S. Customs Carrier General Order Status'],
            [ 'id' => 353, 'edg_group_name' => '353', 'edg_description' => 'Customs Events Advisory Details'],
            [ 'id' => 354, 'edg_group_name' => '354', 'edg_description' => 'U.S. Customs Automated Manifest Archive Status'],
            [ 'id' => 355, 'edg_group_name' => '355', 'edg_description' => 'U.S. Customs Acceptance/Rejection'],
            [ 'id' => 356, 'edg_group_name' => '356', 'edg_description' => 'U.S. Customs Permit to Transfer Request'],
            [ 'id' => 357, 'edg_group_name' => '357', 'edg_description' => 'U.S. Customs In-Bond Information'],
            [ 'id' => 358, 'edg_group_name' => '358', 'edg_description' => 'Customs Consist Information'],
            [ 'id' => 361, 'edg_group_name' => '361', 'edg_description' => 'Carrier Interchange Agreement (Ocean)'],
            [ 'id' => 362, 'edg_group_name' => '362', 'edg_description' => 'Cargo Insurance Advice of Shipment'],
            [ 'id' => 404, 'edg_group_name' => '404', 'edg_description' => 'Rail Carrier Shipment Information'],
            [ 'id' => 410, 'edg_group_name' => '410', 'edg_description' => 'Rail Carrier Freight Details and Invoice'],
            [ 'id' => 414, 'edg_group_name' => '414', 'edg_description' => 'Rail Carhire Settlements'],
            [ 'id' => 417, 'edg_group_name' => '417', 'edg_description' => 'Rail Carrier Waybill Interchange'],
            [ 'id' => 418, 'edg_group_name' => '418', 'edg_description' => 'Rail Advance Interchange Consist'],
            [ 'id' => 419, 'edg_group_name' => '419', 'edg_description' => 'Advance Car Disposition'],
            [ 'id' => 420, 'edg_group_name' => '420', 'edg_description' => 'Car Handling Information'],
            [ 'id' => 421, 'edg_group_name' => '421', 'edg_description' => 'Estimated Time of Arrival and Car Scheduling'],
            [ 'id' => 422, 'edg_group_name' => '422', 'edg_description' => 'Shippers Car Order'],
            [ 'id' => 423, 'edg_group_name' => '423', 'edg_description' => 'Rail Industrial Switch List'],
            [ 'id' => 425, 'edg_group_name' => '425', 'edg_description' => 'Rail Waybill Request'],
            [ 'id' => 426, 'edg_group_name' => '426', 'edg_description' => 'Rail Revenue Waybill'],
            [ 'id' => 429, 'edg_group_name' => '429', 'edg_description' => 'Railroad Retirement Activity'],
            [ 'id' => 431, 'edg_group_name' => '431', 'edg_description' => 'Railroad Station Master File'],
            [ 'id' => 432, 'edg_group_name' => '432', 'edg_description' => 'Rail Deprescription'],
            [ 'id' => 433, 'edg_group_name' => '433', 'edg_description' => 'Railroad Reciprocal Switch File'],
            [ 'id' => 434, 'edg_group_name' => '434', 'edg_description' => 'Railroad Mark Register Update Activity'],
            [ 'id' => 435, 'edg_group_name' => '435', 'edg_description' => 'Standard Transportation Commodity Code Master'],
            [ 'id' => 436, 'edg_group_name' => '436', 'edg_description' => 'Locomotive Information'],
            [ 'id' => 437, 'edg_group_name' => '437', 'edg_description' => 'Railroad Junctions and Interchanges Activity'],
            [ 'id' => 440, 'edg_group_name' => '440', 'edg_description' => 'Shipment Weights'],
            [ 'id' => 451, 'edg_group_name' => '451', 'edg_description' => 'Railroad Event Report'],
            [ 'id' => 452, 'edg_group_name' => '452', 'edg_description' => 'Railroad Problem Log Inquiry or Advice'],
            [ 'id' => 453, 'edg_group_name' => '453', 'edg_description' => 'Railroad Service Commitment Advice'],
            [ 'id' => 455, 'edg_group_name' => '455', 'edg_description' => 'Railroad Parameter Trace Registration'],
            [ 'id' => 456, 'edg_group_name' => '456', 'edg_description' => 'Railroad Equipment Inquiry or Advice'],
            [ 'id' => 460, 'edg_group_name' => '460', 'edg_description' => 'Railroad Price Distribution Request or Response'],
            [ 'id' => 463, 'edg_group_name' => '463', 'edg_description' => 'Rail Rate Reply'],
            [ 'id' => 466, 'edg_group_name' => '466', 'edg_description' => 'Rate Request'],
            [ 'id' => 468, 'edg_group_name' => '468', 'edg_description' => 'Rate Docket Journal Log'],
            [ 'id' => 470, 'edg_group_name' => '470', 'edg_description' => 'Railroad Clearance'],
            [ 'id' => 475, 'edg_group_name' => '475', 'edg_description' => 'Rail Route File Maintenance'],
            [ 'id' => 485, 'edg_group_name' => '485', 'edg_description' => 'Ratemaking Action'],
            [ 'id' => 486, 'edg_group_name' => '486', 'edg_description' => 'Rate Docket Expiration'],
            [ 'id' => 490, 'edg_group_name' => '490', 'edg_description' => 'Rate Group Definition'],
            [ 'id' => 492, 'edg_group_name' => '492', 'edg_description' => 'Miscellaneous Rates'],
            [ 'id' => 494, 'edg_group_name' => '494', 'edg_description' => 'Rail Scale Rates'],
            [ 'id' => 500, 'edg_group_name' => '500', 'edg_description' => 'Medical Event Reporting'],
            [ 'id' => 501, 'edg_group_name' => '501', 'edg_description' => 'Vendor Performance Review'],
            [ 'id' => 503, 'edg_group_name' => '503', 'edg_description' => 'Pricing History'],
            [ 'id' => 504, 'edg_group_name' => '504', 'edg_description' => 'Clauses and Provisions'],
            [ 'id' => 511, 'edg_group_name' => '511', 'edg_description' => 'Requisition'],
            [ 'id' => 517, 'edg_group_name' => '517', 'edg_description' => 'Material Obligation Validation'],
            [ 'id' => 521, 'edg_group_name' => '521', 'edg_description' => 'Income or Asset Offset'],
            [ 'id' => 527, 'edg_group_name' => '527', 'edg_description' => 'Material Due-In and Receipt'],
            [ 'id' => 536, 'edg_group_name' => '536', 'edg_description' => 'Logistics Reassignment'],
            [ 'id' => 540, 'edg_group_name' => '540', 'edg_description' => 'Notice of Employment Status'],
            [ 'id' => 561, 'edg_group_name' => '561', 'edg_description' => 'Contract Abstract'],
            [ 'id' => 567, 'edg_group_name' => '567', 'edg_description' => 'Contract Completion Status'],
            [ 'id' => 568, 'edg_group_name' => '568', 'edg_description' => 'Contract Payment Management Report'],
            [ 'id' => 601, 'edg_group_name' => '601', 'edg_description' => 'U.S. Customs Export Shipment Information'],
            [ 'id' => 602, 'edg_group_name' => '602', 'edg_description' => 'Transportation Services Tender'],
            [ 'id' => 620, 'edg_group_name' => '620', 'edg_description' => 'Excavation Communication'],
            [ 'id' => 625, 'edg_group_name' => '625', 'edg_description' => 'Well Information'],
            [ 'id' => 650, 'edg_group_name' => '650', 'edg_description' => 'Maintenance Service Order'],
            [ 'id' => 715, 'edg_group_name' => '715', 'edg_description' => 'Intermodal Group Loading Plan'],
            [ 'id' => 805, 'edg_group_name' => '805', 'edg_description' => 'Contract Pricing Proposal'],
            [ 'id' => 806, 'edg_group_name' => '806', 'edg_description' => 'Project Schedule Reporting'],
            [ 'id' => 810, 'edg_group_name' => '810', 'edg_description' => 'Invoice'],
            [ 'id' => 811, 'edg_group_name' => '811', 'edg_description' => 'Consolidated Service Invoice/Statement'],
            [ 'id' => 812, 'edg_group_name' => '812', 'edg_description' => 'Credit/Debit Adjustment'],
            [ 'id' => 813, 'edg_group_name' => '813', 'edg_description' => 'Electronic Filing of Tax Return Data'],
            [ 'id' => 814, 'edg_group_name' => '814', 'edg_description' => 'General Request'],
            [ 'id' => 815, 'edg_group_name' => '815', 'edg_description' => 'Cryptographic Service Message'],
            [ 'id' => 816, 'edg_group_name' => '816', 'edg_description' => 'Organizational Relationships'],
            [ 'id' => 818, 'edg_group_name' => '818', 'edg_description' => 'Commission Sales Report'],
            [ 'id' => 819, 'edg_group_name' => '819', 'edg_description' => 'Operating Expense Statement'],
            [ 'id' => 820, 'edg_group_name' => '820', 'edg_description' => 'Payment Order/Remittance Advice'],
            [ 'id' => 821, 'edg_group_name' => '821', 'edg_description' => 'Financial Information Reporting'],
            [ 'id' => 822, 'edg_group_name' => '822', 'edg_description' => 'Account Analysis'],
            [ 'id' => 823, 'edg_group_name' => '823', 'edg_description' => 'Lockbox'],
            [ 'id' => 824, 'edg_group_name' => '824', 'edg_description' => 'Application Advice'],
            [ 'id' => 826, 'edg_group_name' => '826', 'edg_description' => 'Tax Information Exchange'],
            [ 'id' => 827, 'edg_group_name' => '827', 'edg_description' => 'Financial Return Notice'],
            [ 'id' => 828, 'edg_group_name' => '828', 'edg_description' => 'Debit Authorization'],
            [ 'id' => 829, 'edg_group_name' => '829', 'edg_description' => 'Payment Cancellation Request'],
            [ 'id' => 830, 'edg_group_name' => '830', 'edg_description' => 'Planning Schedule with Release Capability'],
            [ 'id' => 831, 'edg_group_name' => '831', 'edg_description' => 'Application Control Totals'],
            [ 'id' => 832, 'edg_group_name' => '832', 'edg_description' => 'Price/Sales Catalog'],
            [ 'id' => 833, 'edg_group_name' => '833', 'edg_description' => 'Mortgage Credit Report Order'],
            [ 'id' => 834, 'edg_group_name' => '834', 'edg_description' => 'Benefit Enrollment and Maintenance'],
            [ 'id' => 835, 'edg_group_name' => '835', 'edg_description' => 'Health Care Claim Payment/Advice'],
            [ 'id' => 836, 'edg_group_name' => '836', 'edg_description' => 'Procurement Notices'],
            [ 'id' => 837, 'edg_group_name' => '837', 'edg_description' => 'Health Care Claim'],
            [ 'id' => 838, 'edg_group_name' => '838', 'edg_description' => 'Trading Partner Profile'],
            [ 'id' => 839, 'edg_group_name' => '839', 'edg_description' => 'Project Cost Reporting'],
            [ 'id' => 840, 'edg_group_name' => '840', 'edg_description' => 'Request for Quotation'],
            [ 'id' => 841, 'edg_group_name' => '841', 'edg_description' => 'Specifications/Technical Information'],
            [ 'id' => 842, 'edg_group_name' => '842', 'edg_description' => 'Nonconformance Report'],
            [ 'id' => 843, 'edg_group_name' => '843', 'edg_description' => 'Response to Request for Quotation'],
            [ 'id' => 844, 'edg_group_name' => '844', 'edg_description' => 'Product Transfer Account Adjustment'],
            [ 'id' => 845, 'edg_group_name' => '845', 'edg_description' => 'Price Authorization Acknowledgement/Status'],
            [ 'id' => 846, 'edg_group_name' => '846', 'edg_description' => 'Inventory Inquiry/Advice'],
            [ 'id' => 847, 'edg_group_name' => '847', 'edg_description' => 'Material Claim'],
            [ 'id' => 848, 'edg_group_name' => '848', 'edg_description' => 'Material Safety Data Sheet'],
            [ 'id' => 849, 'edg_group_name' => '849', 'edg_description' => 'Response to Product Transfer Account Adjustment'],
            [ 'id' => 850, 'edg_group_name' => '850', 'edg_description' => 'Purchase Order'],
            [ 'id' => 851, 'edg_group_name' => '851', 'edg_description' => 'Asset Schedule'],
            [ 'id' => 852, 'edg_group_name' => '852', 'edg_description' => 'Product Activity Data'],
            [ 'id' => 853, 'edg_group_name' => '853', 'edg_description' => 'Routing and Carrier Instruction'],
            [ 'id' => 854, 'edg_group_name' => '854', 'edg_description' => 'Shipment Delivery Discrepancy Information'],
            [ 'id' => 855, 'edg_group_name' => '855', 'edg_description' => 'Purchase Order Acknowledgement'],
            [ 'id' => 856, 'edg_group_name' => '856', 'edg_description' => 'Ship Notice/Manifest'],
            [ 'id' => 857, 'edg_group_name' => '857', 'edg_description' => 'Shipment and Billing Notice'],
            [ 'id' => 858, 'edg_group_name' => '858', 'edg_description' => 'Shipment Information'],
            [ 'id' => 859, 'edg_group_name' => '859', 'edg_description' => 'Freight Invoice'],
            [ 'id' => 860, 'edg_group_name' => '860', 'edg_description' => 'Purchase Order Change Request - Buyer Initiated'],
            [ 'id' => 861, 'edg_group_name' => '861', 'edg_description' => 'Receiving Advice/Acceptance Certificate'],
            [ 'id' => 862, 'edg_group_name' => '862', 'edg_description' => 'Shipping Schedule'],
            [ 'id' => 863, 'edg_group_name' => '863', 'edg_description' => 'Report of Test Results'],
            [ 'id' => 864, 'edg_group_name' => '864', 'edg_description' => 'Text Message'],
            [ 'id' => 865, 'edg_group_name' => '865', 'edg_description' => 'Purchase Order Change Acknowledgement/Request -Seller Initiated'],
            [ 'id' => 866, 'edg_group_name' => '866', 'edg_description' => 'Production Sequence'],
            [ 'id' => 867, 'edg_group_name' => '867', 'edg_description' => 'Product Transfer and Resale Report'],
            [ 'id' => 868, 'edg_group_name' => '868', 'edg_description' => 'Electronic Form Structure'],
            [ 'id' => 869, 'edg_group_name' => '869', 'edg_description' => 'Order Status Inquiry'],
            [ 'id' => 870, 'edg_group_name' => '870', 'edg_description' => 'Order Status Report'],
            [ 'id' => 871, 'edg_group_name' => '871', 'edg_description' => 'Component Parts Content'],
            [ 'id' => 872, 'edg_group_name' => '872', 'edg_description' => 'Residential Mortgage Insurance Application'],
            [ 'id' => 875, 'edg_group_name' => '875', 'edg_description' => 'Grocery Products Purchase Order'],
            [ 'id' => 876, 'edg_group_name' => '876', 'edg_description' => 'Grocery Products Purchase Order Change'],
            [ 'id' => 877, 'edg_group_name' => '877', 'edg_description' => 'Manufacturer Coupon Family Code Structure'],
            [ 'id' => 878, 'edg_group_name' => '878', 'edg_description' => 'Product Authorization/De-authorization'],
            [ 'id' => 879, 'edg_group_name' => '879', 'edg_description' => 'Price Information'],
            [ 'id' => 880, 'edg_group_name' => '880', 'edg_description' => 'Grocery Products Invoice'],
            [ 'id' => 881, 'edg_group_name' => '881', 'edg_description' => 'Manufacturer Coupon Redemption Detail'],
            [ 'id' => 882, 'edg_group_name' => '882', 'edg_description' => 'Direct Store Delivery Summary Information'],
            [ 'id' => 883, 'edg_group_name' => '883', 'edg_description' => 'Market Development Fund Allocation'],
            [ 'id' => 884, 'edg_group_name' => '884', 'edg_description' => 'Market Development Fund Settlement'],
            [ 'id' => 885, 'edg_group_name' => '885', 'edg_description' => 'Retail Account Characteristics'],
            [ 'id' => 886, 'edg_group_name' => '886', 'edg_description' => 'Customer Call Reporting'],
            [ 'id' => 887, 'edg_group_name' => '887', 'edg_description' => 'Coupon Notification'],
            [ 'id' => 888, 'edg_group_name' => '888', 'edg_description' => 'Item Maintenance'],
            [ 'id' => 889, 'edg_group_name' => '889', 'edg_description' => 'Promotion Announcement'],
            [ 'id' => 891, 'edg_group_name' => '891', 'edg_description' => 'Deduction Research Report'],
            [ 'id' => 893, 'edg_group_name' => '893', 'edg_description' => 'Item Information Request'],
            [ 'id' => 894, 'edg_group_name' => '894', 'edg_description' => 'Delivery/Return Base Record'],
            [ 'id' => 895, 'edg_group_name' => '895', 'edg_description' => 'Delivery/Return Acknowledgement or Adjustment'],
            [ 'id' => 896, 'edg_group_name' => '896', 'edg_description' => 'Product Dimension Maintenance'],
            [ 'id' => 920, 'edg_group_name' => '920', 'edg_description' => 'Loss or Damage Claim - General Commodities'],
            [ 'id' => 924, 'edg_group_name' => '924', 'edg_description' => 'Loss or Damage Claim - Motor Vehicle'],
            [ 'id' => 925, 'edg_group_name' => '925', 'edg_description' => 'Claim Tracer'],
            [ 'id' => 926, 'edg_group_name' => '926', 'edg_description' => 'Claim Status Report and Tracer Reply'],
            [ 'id' => 928, 'edg_group_name' => '928', 'edg_description' => 'Automotive Inspection Detail'],
            [ 'id' => 940, 'edg_group_name' => '940', 'edg_description' => 'Warehouse Shipping Order'],
            [ 'id' => 943, 'edg_group_name' => '943', 'edg_description' => 'Warehouse Stock Transfer Shipment Advice'],
            [ 'id' => 944, 'edg_group_name' => '944', 'edg_description' => 'Warehouse Stock Transfer Receipt Advice'],
            [ 'id' => 945, 'edg_group_name' => '945', 'edg_description' => 'Warehouse Shipping Advice'],
            [ 'id' => 947, 'edg_group_name' => '947', 'edg_description' => 'Warehouse Inventory Adjustment Advice'],
            [ 'id' => 980, 'edg_group_name' => '980', 'edg_description' => 'Functional Group Totals'],
            [ 'id' => 990, 'edg_group_name' => '990', 'edg_description' => 'Response to a Load Tender'],
            [ 'id' => 993, 'edg_group_name' => '993', 'edg_description' => 'Secured Receipt or Acknowledgement'],
            [ 'id' => 996, 'edg_group_name' => '996', 'edg_description' => 'File Transfer'],
            [ 'id' => 997, 'edg_group_name' => '997', 'edg_description' => 'Functional Acknowledgement'],
            [ 'id' => 998, 'edg_group_name' => '998', 'edg_description' => 'Set Cancellation'],
            [ 'id' => 999, 'edg_group_name' => '999', 'edg_description' => 'Implementation Acknowledgement']
        ]);
    }
}
