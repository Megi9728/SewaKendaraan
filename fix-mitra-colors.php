<?php
$content = file_get_contents('resources/views/mitra/vehicles/index.blade.php');

// Primary colors
$content = str_replace('bg-blue-600', 'bg-[#0A174E]', $content);
$content = str_replace('hover:bg-blue-700', 'hover:bg-[#0A174E]/90', $content);
$content = str_replace('text-blue-600', 'text-[#0A174E]', $content);
$content = str_replace('text-blue-500', 'text-[#0A174E]/80', $content);
$content = str_replace('bg-blue-50', 'bg-[#EBEBDF]', $content); // Or bg-[#F9F9F5]
$content = str_replace('hover:bg-blue-100', 'hover:bg-[#D4D4C3]', $content);
$content = str_replace('border-blue-100', 'border-[#EBEBDF]', $content);
$content = str_replace('border-blue-400', 'border-[#0A174E]', $content);
$content = str_replace('ring-blue-300', 'ring-[#0A174E]/30', $content);

// Text colors for headings / values
$content = str_replace('text-slate-900', 'text-[#0A174E]', $content);
$content = str_replace('text-slate-800', 'text-[#0A174E]', $content);
$content = str_replace('text-slate-700', 'text-[#0A174E]/80', $content);
$content = str_replace('text-slate-600', 'text-[#0A174E]/70', $content);
$content = str_replace('text-slate-500', 'text-[#0A174E]/60', $content);
$content = str_replace('text-slate-400', 'text-[#8F8F7E]', $content);
$content = str_replace('text-slate-300', 'text-[#BDBDAC]', $content);

// Background / Grays
$content = preg_replace('/bg-slate-50(?!\/)/', 'bg-[#F9F9F5]', $content);
$content = str_replace('bg-slate-50/70', 'bg-[#F9F9F5]/70', $content);
$content = str_replace('bg-slate-50/50', 'bg-[#F9F9F5]/50', $content);
$content = str_replace('bg-slate-100', 'bg-[#EBEBDF]', $content);
$content = str_replace('bg-slate-200', 'bg-[#D4D4C3]', $content);
$content = str_replace('bg-slate-900', 'bg-[#0A174E]', $content);

// Borders
$content = str_replace('border-slate-100', 'border-[#EBEBDF]', $content);
$content = str_replace('border-slate-200', 'border-[#D4D4C3]', $content);
$content = str_replace('divide-slate-50', 'divide-[#F9F9F5]', $content);

// Change the CTA button (Tambah Kendaraan) to use the Maize accent color
$content = str_replace('<button id="btn-tambah" class="flex items-center gap-2 bg-[#0A174E] hover:bg-[#0A174E]/90 text-white', '<button id="btn-tambah" class="flex items-center gap-2 bg-[#F5D042] hover:opacity-90 text-[#0A174E]', $content);


// Add maize accent color to the table headers
$content = preg_replace('/<thead class="bg-\[#F9F9F5\] border-b border-\[#EBEBDF\]">/i', '<thead class="bg-[#0A174E] border-b border-[#EBEBDF]">', $content);
$content = preg_replace('/<th class="text-left px-6 py-4 text-xs font-bold text-\[#8F8F7E\] uppercase tracking-wider">/i', '<th class="text-left px-6 py-4 text-xs font-bold text-[#EBEBDF] uppercase tracking-wider">', $content);
$content = preg_replace('/<th class="text-right px-6 py-4 text-xs font-bold text-\[#8F8F7E\] uppercase tracking-wider">/i', '<th class="text-right px-6 py-4 text-xs font-bold text-[#EBEBDF] uppercase tracking-wider">', $content);


file_put_contents('resources/views/mitra/vehicles/index.blade.php', $content);
