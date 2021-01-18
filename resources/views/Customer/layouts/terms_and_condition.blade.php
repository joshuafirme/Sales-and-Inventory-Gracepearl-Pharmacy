@extends('customer.layouts.main')

@section('content')

        @if(count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
    
                <li>{{$error}}</li>
                    
                @endforeach
            </ul>
        </div>
        @endif

        <div class="row">

            <div class="col-6 m-auto">
                <h4 class="mt-5 mb-3">Terms of Use</h4>
                <p> Welcome to Gracepearl Pharmacy platform. Please read these terms and conditions carefully. The following Terms of Use govern your use and access of the Platform (defined below) and the use of the Services. By accessing the Platform and/or using the Services, you agree to be bound by these Terms of Use. If you do not agree to these Terms of Use, do not access and/or use this Platform or the Services.</p>
                <p>  Access to and use of password protected and/or secure areas of the Platform and/or use of the Services are restricted to Customers with accounts only. You may not obtain or attempt to obtain unauthorized access to such parts of this Platform and/or Services, or to any other protected information, through any means not intentionally made available by us for your specific use.</p>
                <p>  If you are below 18 years old: you must obtain consent from your parent(s) or legal guardian(s), their acceptance of these Terms of Use and their agreement to take responsibility for: (i) your actions; (ii) any charges associated with your use of any of the Services or purchase of Products; and (iii) your acceptance and compliance with these Terms of Use. If you do not have consent from your parent(s) or legal guardian(s), you must stop using/accessing this Platform and using the Services.</p>
                <strong>  1. Definitions & Interpretation</strong><br>
                <p>Unless otherwise defined, the definitions and provisions in respect of interpretation set out in Schedule 1 will apply to these Terms of Use.</p>
                <strong> 2. General use of Services and/or access of Platform</strong>
                <p> 2.1 Guidelines to the use of Platform and/or Services: You agree to comply with any and all the guidelines, notices, operating rules and policies and instructions pertaining to the use of the Services and/or access to the Platform, as well as any amendments to the aforementioned, issued by us, from time to time. We reserve the right to revise these guidelines, notices, operating rules and policies and instructions at any time and you are deemed to be aware of and bound by any changes to the foregoing upon their publication on the Platform.</p>
                <p> 2.2 Restricted activities: You agree and undertake NOT to:</p>    
                <p>(a) Impersonate any person or entity or to falsely state or otherwise misrepresent your affiliation with any person or entity;</p>
                <p>(b) Use the Platform or Services for illegal purposes;</p>
                <p>(c) attempt to gain unauthorized access to or otherwise interfere or disrupt other computer systems or networks connected to the Platform or Services;</p>
                <p>(d) Post, promote or transmit through the Platform or Services any Prohibited Medicine;</p>
                <p>(e) Interfere with another’s utilization and enjoyment of the Platform or Services;</p>
                <p>(f) use or upload, in any way, any software or material that contains, or which you have reason to suspect that contains, viruses, damaging components, malicious code or harmful components which may impair or corrupt the Platform’s data or damage or interfere with the operation of another Customer’s computer or mobile device or the Platform or Services; and</p>
                <p>(g) Use the Platform or Services other than in conformance with the acceptable use policies of any connected computer networks, any applicable Internet standards and any other applicable laws.</p>
                <p>2.3 Availability of Platform and Services: We may, from time to time and without giving any reason or prior notice, upgrade, modify, suspend or discontinue the provision of or remove, whether in whole or in part, the Platform or any Services and shall not be liable if any such upgrade, modification, suspension or removal prevents you from accessing the Platform or any part of the Services.</p>
                <p>2.4 Right, but not obligation, to monitor content: We reserve the right, but shall not be obliged to:</p>
                <p>(a) Monitor, screen or otherwise control any activity, content or material on the Platform and/or through the Services. We may in our sole and absolute discretion, investigate any violation of the terms and conditions contained herein and may take any action it deems appropriate;</p>
                <p>(b) Prevent or restrict access of any Customer to the Platform and/or the Services;</p>
                <p>(c) Report any activity it suspects to be in violation of any applicable law, statute or regulation to the appropriate authorities and to co-operate with such authorities; and/or</p>
                <p>(d) to request any information and data from you in connection with your use of the Services and/or access of the Platform at any time and to exercise our right under this paragraph if you refuse to divulge such information and/or data or if you provide or if we have reasonable grounds to suspect that you have provided inaccurate, misleading or fraudulent information and/or data.</p>
                <p>2.5 Privacy Policy: Your use of the Services and/or access to the Platform is also subject to the Privacy Policy as set out Here.</p>
                <p>2.6 Terms & Conditions of Sale: Purchases of any Product would be subject to the Terms & Conditions of Sale.</p>
                <p>2.7 Additional terms: In addition to these Terms of Use, the use of specific aspects of the product and services, more comprehensive or updated versions of the Product offered by us or our designated sub-contractors, may be subject to additional terms and conditions, which will apply in full force and effect.</p>
                <strong>3. Use of Services</strong>
                <p> 3.1 Application of this Clause: In addition to all other terms and conditions of these Terms of Use, the provisions in this Clause 3 are the additional specific terms and conditions governing your use of the Services.</p>
                <p>3.2 Restrictions: Use of the Services is limited to authorized Customers that are of legal age and who have the legal capacity to enter into and form contracts under any applicable law. Customers who have breached or are in breach of the terms and conditions contained herein and Customers who have been permanently or temporarily suspended from use of any of the Services may not use the Services even if they satisfy the requirements of this Clause 3.2.</p>
                <p>3.3 General terms of use: You agree:</p>
                <p>(a) to access and/or use the Services only for lawful purposes and in a lawful manner at all times and further agree to conduct any activity relating to the Services in good faith; and</p>
                <p>(b) to ensure that any information or data you post or cause to appear on the Platform in connection with the Services is accurate and agree to take sole responsibility for such information and data.</p>
                <p>3.4 Product description: While we endeavor to provide an accurate description of the Products, we do not warrant that such description is accurate, current or free from error.</p>
                <p>3.5 Prices of Products: All Listing Prices are subject to taxes, unless otherwise stated. We reserve the right to amend the Listing Prices at any time without giving any reason or prior notice.
                <p> 3.6 Third Party Vendors: You acknowledge that parties other than Gracepearl Pharmacy (i.e. Third Party-Vendors or Sellers) list and sell Products on the Platform. Whether a particular Product is listed for sale on the Platform by gracepearl pharmacy or a Third-Party Vendor may be stated on the webpage listing that Product. For the avoidance of doubt, each agreement entered into for the sale of a Third-Party Vendor’s Products to a Customer shall be an agreement entered into directly and only between the Third-Party Vendor and the Customer. You further acknowledge that Third Party Vendors may utilize paid services offered by Gracepearl Pharmacy to promote their Product listings within your search results on the Platform.</p>
                <strong>4. Customers with Gracepearl Pharmacy accounts</strong>
                <p>4.1 Username/Password: Certain Services that may be made available on the Platform may require creation of an account with us or for you to provide Personal Data. If you request to create an account with us, a Username and Password may either be: (i) determined and issued to you by us; or (ii) provided by you and accepted by us in our sole and absolute discretion in connection with the use of the Services and/or access to the relevant Platform. We may at any time in our sole and absolute discretion, request that you update your Personal Data or forthwith invalidate the Username and/or Password without giving any reason or prior notice and shall not be liable or responsible for any Losses suffered by or caused by you or arising out of or in connection with or by reason of such request or invalidation. You hereby agree to change your Password from time to time and to keep the Username and Password confidential and shall be responsible for the security of your account and liable for any disclosure or use (whether such use is authorized or not) of the Username and/or Password. You should notify us immediately if you have knowledge that or have reason for suspecting that the confidentiality of the Username and/or Password has been compromised or if there has been any unauthorized use of the Username and/or Password or if your Personal Data requires updating.</p>
                <p>4.2 Purported use/access: You agree and acknowledge that any use of the Services and/or any access to the Platform and any information, data or communications referable to your Username and Password shall be deemed to be, as the case may be:</p>
                <p>• (a) access to the relevant Platform and/or use of the Services by you; or</p>
                <p>• (b) information, data or communications posted, transmitted and validly issued by you.</p>
                <p>You agree to be bound by any access of the Platform and/or use of any Services (whether such access or use are authorized by you or not) and you agree that we shall be entitled (but not obliged) to act upon, rely on or hold you solely responsible and liable in respect thereof as if the same were carried out or transmitted by you. You further agree and acknowledge that you shall be bound by and agree to fully indemnify us against any and all Losses attributable to any use of any Services and/or or access to the Platform referable to your Username and Password.</p>
                <strong>5. Intellectual property</strong>
                <p>5.1 Ownership: The Intellectual Property in and to the Platform and the product are owned, licensed to or controlled by us, our licensors or our service providers. We reserve the right to enforce its Intellectual Property to the fullest extent of the law.</p>
                <p>5.2 Restricted use: No part or parts of the Platform, or any Materials may be reproduced, reverse engineered, decompiled, disassembled, separated, altered, distributed, republished, displayed, broadcast, hyperlinked, mirrored, framed, transferred or transmitted in any manner or by any means or stored in an information retrieval system or installed on any servers, system or equipment without our prior written permission or that of the relevant copyright owners. Subject to Clause 5.3, permission will only be granted to you to download, print or use the Product for personal and non-commercial uses, provided that you do not modify the Products and that we or the relevant copyright owners retain all copyright and other proprietary notices contained in the Products.</p>
                <p>5.3 Trademarks: The Trademarks are registered and unregistered trademarks of us or third parties. Nothing on the Platform and in these Terms of Use shall be construed as granting, by implication, estoppel, or otherwise, any license or right to use (including as a meta tag or as a “hot” link to any other website) any Trademarks displayed on the Services, without our written permission or any other applicable trademark owner.</p>
                
                <strong>6. Our limitation of responsibility and liability</strong>
                <p>6.1 No representations or warranties: The Services, the Platform and the Products are provided on an “as is” and “as available” basis. All data and/or information contained in the Platform, the Services or the Products are provided for informational purposes only. No representations or warranties of any kind, implied, express or statutory, including the warranties of non-infringement of third party rights, title, merchantability, satisfactory quality or fitness for a particular purpose, are given in conjunction with the Platform, the Services or the Products. Without prejudice to the generality of the foregoing, we do not warrant:</p>
                <p>(a) the accuracy, timeliness, adequacy, commercial value or completeness of all data and/or information contained in the Platform, the Services or the Products;</p>
                <p>(b) that the Platform, the Services or that any of the Products will be provided uninterrupted, secure or free from errors or omissions, or that any identified defect will be corrected;</p>
                <p>(c) that the Platform, the Services or the Products are free from any computer virus or other malicious, destructive or corrupting code, agent, program or macros; and</p>
                <p>(d) the security of any information transmitted by you or to you through the Platform or the Services, and you accept the risk that any information transmitted or received through the Services or the Platform may be accessed by unauthorized third parties and/or disclosed by us or our officers, employees or agents to third parties purporting to be you or purporting to act under your authority. Transmissions over the Internet and electronic mail may be subject to interruption, transmission blackout, delayed transmission due to internet traffic or incorrect data transmission due to the public nature of the Internet.</p>
                <p>6.2 Exclusion of liability: Gracepearl Pharmacy Indemnitees shall not be liable to you for any Losses whatsoever or howsoever caused (regardless of the form of action) arising directly or indirectly in connection with:</p>
                <p>(a) any access, use and/or inability to use the Platform or the Services;</p>
                <p>(b) reliance on any data or information made available through the Platform and/or through the Services. You should not act on such data or information without first independently verifying its contents;</p>
                <p>(c) any system, server or connection failure, error, omission, interruption, delay in transmission, computer virus or other malicious, destructive or corrupting code, agent program or macros; and</p>
                <p>(d) any use of or access to any other website or webpage linked to the Platform, even if we or our officers or agents or employees may have been advised of, or otherwise might have anticipated, the possibility of the same.</p>
                <p>6.3 At your own risk: Any risk of misunderstanding, error, damage, expense or Losses resulting from the use of the Platform is entirely at your own risk and we shall not be liable therefor.</p>
                
            </div>

        </div>
                


        </div>
    </div>

        <!-- /.row (main row) -->
        
</div><!-- /.container-fluid -->
  
    <!-- /.content -->

    @extends('customer.layouts.loading_modal')
    @section('modals')
    @endsection

@endsection



