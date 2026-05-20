<h2>New Service Request</h2>

<p><strong>Name:</strong> {{ $serviceRequest->full_name }}</p>
<p><strong>Company:</strong> {{ $serviceRequest->company_name }}</p>
<p><strong>Email:</strong> {{ $serviceRequest->company_email }}</p>
<p><strong>Phone:</strong> {{ $serviceRequest->phone_no }}</p>
<p><strong>Website:</strong> {{ $serviceRequest->company_website ?: 'N/A' }}</p>
<p><strong>Country:</strong> {{ $serviceRequest->country ?: 'N/A' }}</p>
<p><strong>Service:</strong> {{ $serviceRequest->service_type }}</p>
