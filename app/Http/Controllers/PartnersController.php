<?php

namespace SisConPat\Http\Controllers;

use Illuminate\Http\Request;

use SisConPat\Http\Requests;
use SisConPat\Http\Controllers\Controller;
use SisConPat\Repositories\RegionRepository;
use SisConPat\Repositories\CityRepository;
use SisConPat\Repositories\PartnerRepository;
use SisConPat\Repositories\PartnerTypeRepository;

use Session;

class PartnersController extends Controller
{
    private $partnerRepository;

    public function __construct(PartnerRepository $partnerRepository)
    {
        $this->partnerRepository = $partnerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
       $partners = $this->partnerRepository->allPartnersByName();
       ##dd($partners);

       return view('partners.index', compact('partners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function search(RegionRepository $regionRepository, CityRepository $cityRepository, PartnerTypeRepository $partner_typeRepository)
    { 
        session()->forget('srch_partner_name');
        session()->forget('srch_partner_region_id');
        session()->forget('srch_partner_city_id');
        session()->forget('srch_partner_type_id');

        $regions = array(''=>'') + $regionRepository
            ->allRegions()
            ->lists('description', 'id')
            ->all();

        $cities = array(''=>'') + $cityRepository
            ->allCities()
            ->lists('description', 'id')
            ->all();

        $partner_types = array(''=>'') + $partner_typeRepository
            ->allPartnerTypes()
            ->lists('description', 'id')
            ->all();

        return view('partners.search', compact('regions', 'cities', 'partner_types'));
    }

    public function search_results(Requests\PartnerSearchRequest $request)
    { 
        $input = $request->all();

        $request->flash();

        session(['srch_partner_name' => $input['srch_partner_name']]);
        #dd(session()->get('srch_partner_name'));
        session()->put('srch_partner_region_id', $input['srch_partner_region_id']);
        session()->put('srch_partner_city_id', $input['srch_partner_city_id']);
        session()->put('srch_partner_type_id', $input['srch_partner_type_id']);
        
        $partners = $this->partnerRepository->searchPartners();

        return view('partners.search_results', compact('partners'));
    }

    public function search_results_back()
    { 
        $partners = $this->partnerRepository->searchPartners();

        return view('partners.search_results', compact('partners'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(CityRepository $cityRepository, PartnerTypeRepository $partner_typeRepository)
    { 
        $cities = array(''=>'') + $cityRepository
            ->allCities()
            ->lists('description', 'id')
            ->all();

        $partner_types = array(''=>'') + $partner_typeRepository
            ->allPartnerTypes()
            ->lists('description', 'id')
            ->all();

        return view('partners.create', compact('cities', 'partner_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Requests\PartnerRequest $request)
    {
        $input = $request->all();

        $input['name'] = strtoupper($input['name']);
        $input['address'] = strtoupper($input['address']);
        $input['neighborhood'] = strtoupper($input['neighborhood']);
        
        $partner = $this->partnerRepository->storePartner($input);
      
        $partner = $this->partnerRepository->allPartnersById()->last();

        return redirect()->route('partners.show', ['id' => $partner->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $partner = $this->partnerRepository->findPartnerById($id);
        $logs = $partner->revisionHistory;
        
        return view('partners.show', compact('partner', 'logs'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function deleted($id)
    {

        $partner = $this->partnerRepository->findPartnerTrashedById($id);
        $logs = $partner->revisionHistory;
        
        return view('partners.deleted', compact('partner', 'logs'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function restore($id)
    {
        $partner = $this->partnerRepository->findPartnerTrashedById($id);
        $partner->restore();

        $logs = $partner->revisionHistory;
        
        return view('partners.show', compact('partner', 'logs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, CityRepository $cityRepository, PartnerTypeRepository $partner_typeRepository)
    { 
        $cities = $cityRepository
            ->allCities()
            ->lists('description', 'id')
            ->all();

        $partner_types = $partner_typeRepository
            ->allPartnerTypes()
            ->lists('description', 'id')
            ->all();
        
        $partner = $this->partnerRepository->findPartnerById($id);

        return view('partners.edit', compact('partner', 'cities', 'partner_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Requests\PartnerRequest $request, $id)
    {
        $input = $request->all();

        $input['name'] = strtoupper($input['name']);
        $input['address'] = strtoupper($input['address']);
        $input['neighborhood'] = strtoupper($input['neighborhood']);

        $partner = $this->partnerRepository->findPartnerById($id);
        $partner->update($input);

        $logs = $partner->revisionHistory;
        
        return view('partners.show', compact('partner', 'logs'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->partnerRepository->findPartnerById($id)->delete();

        Session::flash('flash_message_partner_destroy', 'Registro excluído com sucesso !');

        return redirect()->route('partners.deleted', ['id' => $id]);
    }
}