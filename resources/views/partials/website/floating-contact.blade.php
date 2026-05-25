@php
  $floatingCompanySetting = $websiteCompanySetting ?? null;
  $floatingEmail = $floatingCompanySetting?->email;
  $floatingPhone = $floatingCompanySetting?->phone;
  $floatingWhatsapp = $floatingCompanySetting?->whatsapp_number ?: $floatingPhone;
  $floatingWhatsappDigits = $floatingWhatsapp ? preg_replace('/\D+/', '', $floatingWhatsapp) : null;
  $floatingQuoteLink = $floatingCompanySetting?->quote_link ?: url('/contact');
  $services = $websiteServices ?? collect();

  if ($floatingQuoteLink && ! str_starts_with($floatingQuoteLink, 'http') && ! str_starts_with($floatingQuoteLink, '/')) {
      $floatingQuoteLink = url($floatingQuoteLink);
  }
@endphp
<style>
.tcw-popup-overlay {
  display: none;
  position: fixed;
  inset: 0;
  width: 100%;
  min-height: 100%;
  background: rgba(15, 23, 42, 0.66);
  backdrop-filter: blur(10px);
  justify-content: center;
  align-items: center;
  z-index: 999999;
  padding: 24px;
}

.tcw-popup {
  background:
    linear-gradient(180deg, rgba(255, 255, 255, 0.98) 0%, rgba(248, 250, 252, 0.98) 100%),
    #fff;
  width: 100%;
  max-width: 640px;
  max-height: min(90vh, 760px);
  overflow-y: auto;
  padding: 34px;
  border: 1px solid rgba(226, 232, 240, 0.9);
  border-radius: 28px;
  position: relative;
  box-shadow: 0 32px 80px rgba(15, 23, 42, 0.28);
  scrollbar-width: thin;
}

.tcw-popup::before {
  content: "";
  position: absolute;
  inset: 0 0 auto;
  height: 7px;
  background: var(--cs-accent, #38BDF8);
}

.tcw-popup-close {
  position: absolute;
  top: 18px;
  right: 18px;
  width: 42px;
  height: 42px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 26px;
  line-height: 1;
  border: 1px solid rgba(226, 232, 240, 0.95);
  background: #fff;
  color: #0F172A;
  cursor: pointer;
  border-radius: 50%;
  transition: all 0.3s ease;
  box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
}

.tcw-popup-close:hover {
  transform: rotate(90deg) scale(1.04);
  border-color: rgba(56, 189, 248, 0.45);
  background: #38BDF8;
  color: #fff;
  box-shadow: 0 16px 34px rgba(56, 189, 248, 0.24);
}

.tcw-popup-kicker {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: fit-content;
  margin: 0 auto 14px;
  padding: 8px 14px;
  border-radius: 999px;
  background: rgba(56, 189, 248, 0.12);
  color: #2563EB;
  font-size: 12px;
  font-weight: 800;
  letter-spacing: 0.08em;
  text-transform: uppercase;
}

.tcw-popup h2 {
  font-size: 34px;
  font-weight: 800;
  color: #020617;
  margin: 0 0 10px;
  text-align: center;
  line-height: 1.1;
}

.tcw-popup .tcw-form-intro {
  text-align: center;
  color: #475569;
  max-width: 460px;
  margin: 0 auto 28px;
  font-size: 15px;
  line-height: 1.7;
}

.tcw-popup .tcw-form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
  margin-bottom: 8px;
}

.tcw-popup .tcw-form-field {
  margin-bottom: 8px;
}

.tcw-popup input,
.tcw-popup select {
  width: 100%;
  min-height: 54px;
  padding: 14px 16px;
  border: 1px solid rgba(203, 213, 225, 0.95);
  border-radius: 14px;
  font-size: 14px;
  color: #020617;
  background: #fff;
  transition: all 0.3s ease;
  font-family: 'Archivo', sans-serif;
  box-shadow: 0 1px 0 rgba(15, 23, 42, 0.03);
}

.tcw-popup input:focus,
.tcw-popup select:focus {
  outline: none;
  border-color: #38BDF8;
  background: #fff;
  box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.12);
}

.tcw-popup input::placeholder,
.tcw-popup select::placeholder {
  color: #94a3b8;
}

.tcw-popup .tcw-popup-submit {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  min-height: 56px;
  padding: 14px 24px;
  border: 1px solid #38BDF8;
  border-radius: 14px;
  background: linear-gradient(135deg, #38BDF8 0%, #2563EB 100%);
  color: #fff;
  font-size: 0.84rem;
  font-weight: 800;
  text-transform: uppercase;
  cursor: pointer;
  letter-spacing: 0.08em;
  font-family: 'Archivo', sans-serif;
  transition: transform 0.22s ease, box-shadow 0.22s ease;
  box-shadow: 0 18px 34px rgba(56, 189, 248, 0.24);
}

.tcw-popup .tcw-popup-submit:hover {
  transform: translateY(-2px);
  box-shadow: 0 22px 38px rgba(56, 189, 248, 0.28);
}

.tcw-floating-contact {
  position: fixed;
  z-index: 99999;
}

.tcw-floating-contact__button {
  border: 0;
  cursor: pointer;
}

.tcw-voice-popup {
  max-width: 420px;
  padding: 34px 28px 28px;
  text-align: center;
}

.tcw-voice-orb {
  position: relative;
  width: 84px;
  height: 84px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  margin: 16px auto 20px;
  border-radius: 50%;
  color: #fff;
  background: linear-gradient(135deg, #38BDF8, #2563EB);
  font-size: 30px;
  box-shadow: 0 18px 38px rgba(37, 99, 235, 0.3);
}

.tcw-voice-orb::before,
.tcw-voice-orb::after {
  content: "";
  position: absolute;
  inset: -10px;
  border: 1px solid rgba(56, 189, 248, 0.25);
  border-radius: 50%;
  opacity: 0;
}

.tcw-voice-popup.is-connecting .tcw-voice-orb::before,
.tcw-voice-popup.is-live .tcw-voice-orb::before,
.tcw-voice-popup.is-live .tcw-voice-orb::after {
  animation: tcwVoicePulse 1.8s ease-out infinite;
  opacity: 1;
}

.tcw-voice-popup.is-live .tcw-voice-orb::after {
  animation-delay: 0.65s;
}

@keyframes tcwVoicePulse {
  from { transform: scale(0.9); opacity: 0.6; }
  to { transform: scale(1.45); opacity: 0; }
}

.tcw-voice-popup h2 {
  font-size: 28px;
}

.tcw-voice-status {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  margin: 0 auto 22px;
  padding: 9px 14px;
  border-radius: 999px;
  color: #475569;
  background: #f1f5f9;
  font-size: 13px;
  font-weight: 800;
}

.tcw-voice-status i {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: #94a3b8;
}

.tcw-voice-popup.is-connecting .tcw-voice-status i {
  background: #f59e0b;
}

.tcw-voice-popup.is-live .tcw-voice-status {
  color: #0369a1;
  background: #e0f2fe;
}

.tcw-voice-popup.is-live .tcw-voice-status i {
  background: #22c55e;
}

.tcw-voice-help {
  margin: 0 auto 22px;
  color: #475569;
  font-size: 14px;
  line-height: 1.65;
}

.tcw-ai-call-actions {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
  margin-top: 16px;
}

.tcw-ai-call-actions a,
.tcw-ai-call-actions button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-height: 50px;
  padding: 12px 16px;
  border-radius: 14px;
  font-size: 13px;
  font-weight: 900;
  text-decoration: none;
  text-transform: uppercase;
}

.tcw-ai-call-primary {
  border: 1px solid #38BDF8;
  color: #fff;
  background: linear-gradient(135deg, #38BDF8, #2563EB);
}

.tcw-ai-end-call {
  display: none !important;
  border: 1px solid #ef4444;
  color: #fff;
  background: #ef4444;
}

.tcw-voice-popup.is-live .tcw-ai-call-primary,
.tcw-voice-popup.is-connecting .tcw-ai-call-primary {
  display: none;
}

.tcw-voice-popup.is-live .tcw-ai-end-call,
.tcw-voice-popup.is-connecting .tcw-ai-end-call {
  display: inline-flex !important;
}

.tcw-ai-call-secondary {
  border: 1px solid rgba(15, 23, 42, 0.16);
  color: #0f172a;
  background: #fff;
}

@media (max-width: 767px) {
  .tcw-popup {
    padding: 30px 18px 22px;
    border-radius: 22px;
  }

  .tcw-popup h2 {
    font-size: 26px;
  }

  .tcw-popup .tcw-form-row {
    grid-template-columns: 1fr;
    gap: 8px;
  }

  .tcw-popup input,
  .tcw-popup select {
    min-height: 50px;
    padding: 12px 14px;
    font-size: 13px;
  }

  .tcw-popup-close {
    width: 36px;
    height: 36px;
    font-size: 20px;
    top: 15px;
    right: 15px;
  }

  .tcw-ai-call-actions {
    grid-template-columns: 1fr;
  }

  .tcw-voice-popup {
    padding: 30px 18px 20px;
  }
}

@media (max-width: 480px) {
  .tcw-popup-overlay {
    align-items: flex-start;
    padding: 14px;
  }

  .tcw-popup {
    max-height: calc(100vh - 28px);
    padding: 28px 14px 18px;
    border-radius: 18px;
  }

  .tcw-popup h2 {
    font-size: 24px;
  }

  .tcw-popup .tcw-popup-submit {
    min-height: 48px;
    font-size: 0.8rem;
  }
}

.tcw-popup .phone-field-wrap {
  margin-bottom: 0;
  position: relative;
  width: 100%;
}

.tcw-popup .phone-field-wrap .iti {
  display: block;
  width: 100%;
  margin-bottom: 0;
}

.tcw-popup .phone-field-wrap .iti__flag-container {
  display: block !important;
  opacity: 1 !important;
  visibility: visible !important;
  z-index: 5;
}

.tcw-popup .phone-field-wrap .iti__selected-flag {
  display: flex !important;
  align-items: center;
  min-height: 54px;
  padding: 0 12px;
  border-radius: 14px 0 0 14px;
}

.tcw-popup .phone-field-wrap .iti__flag {
  display: block !important;
  flex: 0 0 auto;
}

.tcw-popup .phone-field-wrap .iti--allow-dropdown input,
.tcw-popup .phone-field-wrap .iti--separate-dial-code input,
.tcw-popup .phone-field-wrap .iti--allow-dropdown input[type="tel"],
.tcw-popup .phone-field-wrap .iti--separate-dial-code input[type="tel"] {
  padding-left: 110px !important;
}

@media (max-width: 767px) {
  .tcw-popup .phone-field-wrap .iti__selected-flag {
    min-height: 50px;
  }
}
</style>
<div class="tcw-floating-contact" aria-label="Quick contact links">
  <div class="tcw-floating-contact__icons">
    @if($floatingWhatsappDigits)
      <a href="https://wa.me/{{ $floatingWhatsappDigits }}" class="tcw-floating-contact__icon" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp">
        <i class="fab fa-whatsapp"></i>
      </a>
    @endif

    @if($floatingEmail)
      <a href="mailto:{{ $floatingEmail }}" class="tcw-floating-contact__icon" aria-label="Send email">
        <i class="far fa-envelope"></i>
      </a>
    @endif

    <button type="button" id="openAiCallFlow" class="tcw-floating-contact__icon tcw-floating-contact__button" aria-label="Call AI receptionist">
      <i class="fas fa-phone"></i>
    </button>
  </div>

  <a href="{{ route('website.quote-generator') }}" class="tcw-floating-contact__quote">
    <span>Get A Quote!</span>
  </a>
</div>

<div id="aiCallFlowPopup" class="tcw-popup-overlay">
  <div class="tcw-popup tcw-voice-popup" data-vapi-call-panel>
    <button class="tcw-popup-close" id="closeAiCallFlow" type="button">&times;</button>

    <div class="tcw-popup-kicker">AI receptionist</div>
    <span class="tcw-voice-orb" aria-hidden="true">
      <i class="fas fa-phone"></i>
    </span>
    <h2>Talk to Our AI Receptionist</h2>
    <p class="tcw-voice-help">Available 24/7 to answer your questions and collect project requirements.</p>

    <div class="tcw-voice-status" role="status" aria-live="polite">
      <i></i>
      <span data-vapi-status>Ready to connect</span>
    </div>

    <div class="tcw-ai-call-actions">
      <button type="button" class="tcw-ai-call-primary" data-vapi-start-call>Start Call</button>
      <button type="button" class="tcw-ai-end-call" data-vapi-end-call>End Call</button>
      <button type="button" class="tcw-ai-call-secondary" id="closeAiCallFlowSecondary">Close</button>
    </div>
  </div>
</div>

<div id="quotePopup" class="tcw-popup-overlay">
  <div class="tcw-popup">
    <button class="tcw-popup-close" id="closeQuotePopup">&times;</button>
    
    <div class="tcw-popup-kicker">Free consultation</div>
    <h2>Start Your Digital Growth Journey</h2>
    <p class="tcw-form-intro">Tell us about your brand, services, or business goals, and we’ll help you choose the right marketing strategy to scale your online presence and maximize conversions.</p>

    <form action="{{ route('services.store.public') }}" method="POST" data-service-request-form novalidate>
      @csrf

      <div class="tcw-form-row">
        <div class="tcw-form-field">
          <input type="text" name="full_name" placeholder="Full Name" required>
        </div>
        <div class="tcw-form-field">
          <input type="text" name="company_name" placeholder="Company Name" required>
        </div>
      </div>

      <div class="tcw-form-row">
        <div class="tcw-form-field">
          <input type="text" name="company_website" placeholder="Company Website">
        </div>
        <div class="tcw-form-field">
          <input type="email" name="company_email" placeholder="Company Email" required>
        </div>
      </div>

      <div class="tcw-form-field">
        <div class="phone-field-wrap">
          <input type="tel" id="quote_full_phone" name="phone_no" placeholder="Phone Number" autocomplete="tel" required>
          <input type="hidden" name="country" id="quote_country_name">
        </div>
      </div>

      <div class="tcw-form-field">
        <select name="service_type" required>
          <option value="">Choose Service</option>
          @foreach($services as $service)
            <option value="{{ $service->service_title }}">
              {{ $service->service_title }}
            </option>
          @endforeach
        </select>
      </div>

      <button type="submit" class="tcw-popup-submit">Submit Request</button>
    </form>

  </div>
</div>



<script>
document.addEventListener("DOMContentLoaded", function () {

  const openBtn = document.getElementById('openQuotePopup');
  const popup = document.getElementById('quotePopup');
  const closeBtn = document.getElementById('closeQuotePopup');

  if (!openBtn || !popup || !closeBtn) {
    return;
  }

  openBtn.addEventListener('click', function(e) {
    e.preventDefault();
    popup.style.display = 'flex';
    window.dispatchEvent(new Event('resize'));
  });

  closeBtn.addEventListener('click', function() {
    popup.style.display = 'none';
  });

  window.addEventListener('click', function(e) {
    if (e.target === popup) {
      popup.style.display = 'none';
    }
  });

});
</script>

<script type="module">
  const publicKey = 'cb76a6ad-b880-49b3-b054-5eb72bb56309';
  const assistantId = 'b0438229-6d34-4a88-b499-664f55278c99';
  const callButton = document.getElementById('openAiCallFlow');
  const callPopup = document.getElementById('aiCallFlowPopup');
  const callPanel = callPopup?.querySelector('[data-vapi-call-panel]');
  const statusText = callPopup?.querySelector('[data-vapi-status]');
  const startButton = callPopup?.querySelector('[data-vapi-start-call]');
  const endButton = callPopup?.querySelector('[data-vapi-end-call]');
  const closeButtons = [
    document.getElementById('closeAiCallFlow'),
    document.getElementById('closeAiCallFlowSecondary'),
  ].filter(Boolean);
  let vapi = null;
  let vapiPromise = null;
  let callAttempt = 0;
  let isStarting = false;
  let isConnected = false;

  if (callButton && callPopup && callPanel && statusText && startButton && endButton) {
    const setStatus = (label, state = '') => {
      statusText.textContent = label;
      callPanel.classList.remove('is-connecting', 'is-live');

      if (state) {
        callPanel.classList.add(state);
      }
    };

    const showPopup = () => {
      callPopup.style.display = 'flex';
    };

    const getVapi = async () => {
      if (vapi) {
        return vapi;
      }

      if (!vapiPromise) {
        vapiPromise = import('https://cdn.jsdelivr.net/npm/@vapi-ai/web@latest/+esm')
          .then(({ default: Vapi }) => {
            vapi = new Vapi(publicKey);

            vapi.on('call-start', () => {
              isStarting = false;
              isConnected = true;
              setStatus('Connected', 'is-live');
            });

            vapi.on('call-end', () => {
              isStarting = false;
              isConnected = false;
              setStatus('Ended');
            });

            vapi.on('error', (error) => {
              isStarting = false;
              isConnected = false;
              setStatus('Connection error');
              console.error('Vapi voice call error.', error);
            });

            return vapi;
          })
          .catch((error) => {
            vapiPromise = null;
            throw error;
          });
      }

      return vapiPromise;
    };

    const startCall = async () => {
      showPopup();

      if (isStarting || isConnected) {
        return;
      }

      const activeAttempt = ++callAttempt;
      isStarting = true;
      setStatus('Connecting...', 'is-connecting');

      try {
        if (!navigator.mediaDevices?.getUserMedia) {
          throw new Error('Microphone access is not supported in this browser.');
        }

        const microphoneStream = await navigator.mediaDevices.getUserMedia({ audio: true });
        microphoneStream.getTracks().forEach((track) => track.stop());

        if (activeAttempt !== callAttempt) {
          return;
        }

        const client = await getVapi();

        if (activeAttempt !== callAttempt) {
          return;
        }

        await client.start(assistantId);
      } catch (error) {
        if (activeAttempt !== callAttempt) {
          return;
        }

        isStarting = false;
        setStatus(error?.name === 'NotAllowedError' ? 'Microphone permission denied' : 'Unable to connect');
        console.error('Vapi voice call could not start.', error);
      }
    };

    const endCall = () => {
      callAttempt++;

      if ((isStarting || isConnected) && vapi) {
        vapi.stop();
      }

      isStarting = false;
      isConnected = false;
      setStatus('Ended');
    };

    callButton.addEventListener('click', (event) => {
      event.preventDefault();
      startCall();
    });

    startButton.addEventListener('click', startCall);
    endButton.addEventListener('click', endCall);

    closeButtons.forEach((button) => {
      button.addEventListener('click', () => {
        endCall();
        callPopup.style.display = 'none';
      });
    });

    window.addEventListener('click', (event) => {
      if (event.target === callPopup) {
        endCall();
        callPopup.style.display = 'none';
      }
    });
  }
</script>
