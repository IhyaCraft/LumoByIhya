<?php
$kelas   = $kelas   ?? '';
$lengkap = $lengkap ?? true;
?>
<svg <?= $kelas ? 'class="' . esc($kelas) . '"' : '' ?> viewBox="0 0 200 220" <?= $lengkap ? 'role="img" aria-label="Maskot Lumo, lampu kecil yang ramah"' : 'aria-hidden="true"' ?>>
  <?php if ($lengkap): ?><rect x="62" y="22" width="76" height="14" rx="7" fill="#F2C94C" opacity=".6"/><?php endif; ?>
  <rect x="30" y="40" width="140" height="130" rx="46" fill="#FBEFC2" stroke="#E9C95A" stroke-width="4"/>
  <rect x="60" y="168" width="80" height="34" rx="14" fill="#C85F1B"/>
  <?php if ($lengkap): ?><rect x="72" y="180" width="56" height="8" rx="4" fill="#F7B27E"/><?php endif; ?>
  <rect x="64" y="90" width="14" height="22" rx="7" fill="#2B2B33"/>
  <rect x="122" y="90" width="14" height="22" rx="7" fill="#2B2B33"/>
  <?php if ($lengkap): ?>
  <rect x="68" y="94" width="5" height="7" rx="2.5" fill="#fff"/>
  <rect x="126" y="94" width="5" height="7" rx="2.5" fill="#fff"/>
  <rect x="46" y="116" width="20" height="12" rx="6" fill="#F7B27E" opacity=".7"/>
  <rect x="134" y="116" width="20" height="12" rx="6" fill="#F7B27E" opacity=".7"/>
  <?php endif; ?>
  <path d="M84 126q16 14 32 0" fill="none" stroke="#2B2B33" stroke-width="6" stroke-linecap="round"/>
</svg>