@while(have_rows('sections')) @php(the_row())
    @includeIf('sections.' . get_row_layout())
@endwhile
