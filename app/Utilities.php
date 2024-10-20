<?php

namespace App;

use Illuminate\Http\Request;

class Utilities {
    // For removing repetitions

    public static function sortedSearchEquals(
        $searchField, $searchKeyword,
        $sortFields, $sortField, $sortFieldOrder, $defaultSortField,
        $class, $static = true
    ) {
        $search = $searchKeyword ?? '';

        $sort = $sortField ?? $defaultSortField;
        $sortOrder = $sortFieldOrder ?? 'asc';

        if (!array_search($sort, $sortFields))
            $sort = $defaultSortField;

        if (!array_search($sortOrder, ['asc', 'desc']))
            $sortOrder = 'asc';

        if ($static == true)
            $class = $class::where($searchField, '=', "$search");
        else
            $class = $class->where($searchField, '=', "$search");

        return $class->orderBy($sort, $sortOrder)->paginate(20);
    }

    public static function sortedSearchLike(
        $searchField, $searchKeyword,
        $sortFields, $sortField, $sortFieldOrder, $defaultSortField,
        $class, $static = true
    ) {
        $search = $searchKeyword ?? '';

        $sort = $sortField ?? $defaultSortField;
        $sortOrder = $sortFieldOrder ?? 'asc';

        if (!array_search($sort, $sortFields))
            $sort = $defaultSortField;

        if (!array_search($sortOrder, ['asc', 'desc']))
            $sortOrder = 'asc';

        if ($static == true)
            $class = $class::where($searchField, 'like', "%$search%");
        else
            $class = $class->where($searchField, 'like', "%$search%");

        return $class->orderBy($sort, $sortOrder)->paginate(20);
    }

    // For creating pagination URLs

    public static function createPaginationURLs(Request $request, $paginatedResults) {
        $urlNoPage = $request->fullUrlWithoutQuery('page');

        if (!strstr($urlNoPage, '?'))
            $urlNoPage = $urlNoPage . '?';

        return [
            'prevPageUrl' => $urlNoPage . '&page=' . ($paginatedResults->currentPage() - 1),
            'nextPageUrl' => $urlNoPage . '&page=' . ($paginatedResults->currentPage() + 1),
        ];
    }
}