<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img width="375px" height="75px" src="{{ getImage(imagePath()['logoIcon']['path'] . '/logo.png') }}"
                    class="logo" alt="{{ getGen()->sitename }} Logo">
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
