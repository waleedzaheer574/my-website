<h2>{{ $serviceRequest->source === 'ai_call' ? 'New AI Call Lead' : 'New Service Request' }}</h2>

<p><strong>Name:</strong> {{ $serviceRequest->full_name }}</p>
<p><strong>Company:</strong> {{ $serviceRequest->company_name }}</p>
<p><strong>Email:</strong> {{ $serviceRequest->company_email }}</p>
<p><strong>Phone:</strong> {{ $serviceRequest->phone_no }}</p>
<p><strong>Website:</strong> {{ $serviceRequest->company_website ?: 'N/A' }}</p>
<p><strong>Country:</strong> {{ $serviceRequest->country ?: 'N/A' }}</p>
<p><strong>Service:</strong> {{ $serviceRequest->service_type }}</p>
<p><strong>Source:</strong> {{ $serviceRequest->source === 'ai_call' ? 'AI Receptionist Call' : 'Website Form' }}</p>

@if($serviceRequest->budget)
<p><strong>Budget:</strong> {{ $serviceRequest->budget }}</p>
@endif

@if($serviceRequest->requirement)
<p><strong>Requirement:</strong> {{ $serviceRequest->requirement }}</p>
@endif

@if($serviceRequest->vapi_call_id)
<p><strong>Vapi Call ID:</strong> {{ $serviceRequest->vapi_call_id }}</p>
@endif

@if($serviceRequest->call_summary)
<p><strong>Call Summary:</strong> {{ $serviceRequest->call_summary }}</p>
@endif
