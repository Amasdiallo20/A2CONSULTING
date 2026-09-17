@php
    $shareUrl = $url ?? url()->current();
    $shareTitle = $title ?? ($site?->site_name ?? 'A2 Consulting');
    $shareText = $text ?? $shareTitle;
    $encodedUrl = rawurlencode($shareUrl);
    $encodedText = rawurlencode($shareText);
    $facebookUrl = 'https://www.facebook.com/sharer/sharer.php?u='.$encodedUrl;
    $whatsappUrl = 'https://wa.me/?text='.rawurlencode($shareText.' '.$shareUrl);
    $twitterUrl = 'https://twitter.com/intent/tweet?url='.$encodedUrl.'&text='.$encodedText;
    $linkedinUrl = 'https://www.linkedin.com/sharing/share-offsite/?url='.$encodedUrl;
@endphp
<div class="share-bar {{ !empty($compact) ? 'share-bar--compact' : '' }}" data-share-bar>
    <p class="share-bar__label">Partager</p>
    <div class="share-bar__actions">
        <a class="share-bar__btn share-bar__btn--facebook"
           href="{{ $facebookUrl }}"
           target="_blank"
           rel="noopener noreferrer"
           title="Partager sur Facebook">
            <i class="fa fa-facebook"></i>
            <span>Facebook</span>
        </a>
        <button type="button"
                class="share-bar__btn share-bar__btn--instagram"
                data-share-copy="{{ $shareUrl }}"
                data-share-instagram="1"
                title="Copier le lien pour Instagram">
            <i class="fa fa-instagram"></i>
            <span>Instagram</span>
        </button>
        <a class="share-bar__btn share-bar__btn--whatsapp"
           href="{{ $whatsappUrl }}"
           target="_blank"
           rel="noopener noreferrer"
           title="Partager sur WhatsApp">
            <i class="fa fa-whatsapp"></i>
            <span>WhatsApp</span>
        </a>
        <a class="share-bar__btn share-bar__btn--twitter"
           href="{{ $twitterUrl }}"
           target="_blank"
           rel="noopener noreferrer"
           title="Partager sur X">
            <i class="fa fa-twitter"></i>
            <span>X</span>
        </a>
        <a class="share-bar__btn share-bar__btn--linkedin"
           href="{{ $linkedinUrl }}"
           target="_blank"
           rel="noopener noreferrer"
           title="Partager sur LinkedIn">
            <i class="fa fa-linkedin"></i>
            <span>LinkedIn</span>
        </a>
        <button type="button"
                class="share-bar__btn share-bar__btn--copy"
                data-share-copy="{{ $shareUrl }}"
                title="Copier le lien">
            <i class="fa fa-link"></i>
            <span>Copier le lien</span>
        </button>
        <button type="button"
                class="share-bar__btn share-bar__btn--native"
                hidden
                data-share-native
                data-share-url="{{ $shareUrl }}"
                data-share-title="{{ $shareTitle }}"
                data-share-text="{{ $shareText }}"
                title="Partager via le téléphone">
            <i class="fa fa-share-alt"></i>
            <span>Plus</span>
        </button>
    </div>
    <p class="share-bar__feedback" data-share-feedback hidden></p>
</div>
