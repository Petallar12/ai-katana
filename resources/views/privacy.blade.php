@extends('layout')
@section('content')

<style>

    .header {
        font-size: 40px;
        font-weight: 400;
        color: white;
        text-align: center;
    }

    .titles {
        font-size: 24px;
        font-weight: 400;
        color: white;
        margin-bottom: 20px;
    }

    .p-section {
        font-size: 15px;
        font-weight: 200;
        color: white;
    }

    .privacy-container {
        width: 50%;
    }

    .footer {
        font-size: 13px;
        font-weight: 200;
        color: white;
        text-align: right;
    }

</style>


<body>
    <main class="d-flex align-items-center justify-content-center">
        <div class="privacy-container">

            <h1 class="header">Data Privacy Notice</h1>
      
                    <br>
                        <h3 class="titles">Introduction</h3>
                        <p class="p-section">At Medishure Insurance Brokers, we are committed to protect the privacy of our clients. This Privacy Notice outlines the types of personal information we collect, how we use and protect it. <br><br>

                        By using the Datalokey web application, you agree to the collection, use, and disclosure of the clients' personal information in accordance with this Privacy Notice.</p>
                    <br>

                        <h3 class="titles">Information We Collect</h3>
                        <p class="p-section">When using Datalokey, we may collect the following types of personal information:
                        <br>
                        <ul class="p-section">
                            <li>Personal details (e.g., name, contact information, date of birth)</li>
                            <li>Insurance details (e.g., policy number, coverage, premium)</li>
                            <li>Other relevant information necessary for providing our services</li>
                        </ul>        
                        </p>
                    <br>

                        <h3 class="titles">How We Use Clients' Information</h3>
                        <p class="p-section">We use clients' personal information for the following purposes:
                        <br>
                        <ul class="p-section">
                            <li>To provide, maintain, and improve our services</li>
                            <li>To communicate with them and provide customer support</li>
                            <li>To generate reports and analytics to enhance our services</li>
                            <li>To comply with legal and regulatory requirements</li>
                        </ul>        
                        </p>
                    <br>

                        <h3 class="titles">Sharing and Disclosure of Information</h3>
                        <p class="p-section">We do not sell or share clients' personal information with third parties for marketing purposes. Disclosing information may be punishable by Law and may lead to imprisonment.</p>
                    <br>

                    <h3 class="titles">Data Security</h3>
                        <p class="p-section">We take data security seriously and have implemented appropriate technical and organizational measures to protect clients' personal information against unauthorized access, disclosure, or destruction. These measures include data encryption, access control, and regular security audits.</p>
                    <br>

                    <h3 class="titles">Retention of Information</h3>
                        <p class="p-section">We retain clients' personal information for as long as necessary to fulfill the purposes for which it was collected or as required by applicable laws and regulations.</p>
                    <br>

                    <h3 class="titles">Your Rights and Choices</h3>
                        <p class="p-section">We have the right to access, correct, or delete clients' personal information held by us. You can also object to or restrict the processing of clients' personal information.</p>
                    <br>

                    <h3 class="titles">Changes to This Privacy Notice</h3>
                        <p class="p-section">We may update this Privacy Notice from time to time to reflect changes in our practices or applicable laws. Any changes will be posted on this page, and we encourage you to review our Privacy Notice periodically to stay informed about our data privacy practices.</p>
                    <br>

                        <p class="footer">Last updated: April 5, 2023</p>
                    <br>
    </main>
</body>

@endsection
