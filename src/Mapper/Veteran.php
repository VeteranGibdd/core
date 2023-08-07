<?php

namespace Gibdd\Core\Mapper;

class Veteran
{
    private \stdClass $data;
    private int $veteranId;
    private int $passportID;
    private int $organisationId;
    private int $dutyId;

    public function __construct(\stdClass $data)
    {
        $this->data = $data;
    }

    public function addDutyId(int $id): Veteran
    {
        $this->dutyId = $id;
        return $this;
    }

    public function addPassportId(int $id): Veteran
    {
        $this->passportID = $id;
        return $this;
    }

    public function addVeteranId(int $id): Veteran
    {
        $this->veteranId = $id;
        return $this;
    }

    public function addOrganisationId(int $id): Veteran
    {
        $this->organisationId = $id;
        return $this;
    }

    public function mappedDutyRow(): array
    {
        $mappedRow = [
            'id' => $this->dutyId ?? null,
            'rank' => $this->data->policeDuty->rank ?? null,
            'length_service' => $this->data->policeDuty->lengthService ?? null,
            'length_service_traffic_police' => $this->data->policeDuty->lengthServiceTrafficPolice ?? null,
            'duty_status' => $this->data->policeDuty->dutyStatus ?? null,
            'retirement_year' => $this->data->policeDuty->retirementYear ?? null,
            'awards' => $this->data->policeDuty->awards ?? null,
            'hostilities_participation' => $this->data->policeDuty->hostilitiesParticipation ?? null,
        ];

        return array_diff($mappedRow, array(null));
    }

    public function mappedPassportRow(): array
    {
        $mappedRow = [
            'id' => $this->passportID ?? null,
            'serial' => $this->data->passport->serial ?? null,
            'number' => $this->data->passport->number ?? null,
            'date_of_issue' => $this->data->passport->dateOfIssue ?? null,
        ];

        return array_diff($mappedRow, array(null));
    }

    public function mappedOrganisationRow(): array
    {
        $mappedRow = [
            'id' => $this->organisationId ?? null,
            'certificate_number' => $this->data->organisation->certNumber ?? null,
            'certificate_validity' => $this->data->organisation->validity ?? null,
            'role' => $this->data->organisation->role ?? null,
            'status' => $this->data->organisation->status ?? null,
            'joining_year' => $this->data->organisation->joiningYear ?? null,
        ];

        return array_diff($mappedRow, array(null));
    }

    public function mappedVeteranRow(): array
    {
        $mappedRow = [
            'id' => $this->veteranId ?? null,
            'first_name' => $this->data->firstName ?? null,
            'last_name' => $this->data->lastName ?? null,
            'middle_name' => $this->data->middleName ?? null,
            'birth_date' => $this->data->birthDate ?? null,
            'district' => $this->data->district ?? null,
            'address' => $this->data->address ?? null,
            'mobile_phone' => $this->data->mobilePhone ?? null,
            'reserve_phone' => $this->data->reservePhone ?? null,
            'email' => $this->data->email ?? null,
            'disability' => $this->data->disability ?? null,
            'additionally' => $this->data->additionally ?? null,
            'duty' => $this->dutyId ?? null,
            'passport' => $this->passportID ?? null,
            'organisation' => $this->organisationId ?? null,
        ];

        return array_diff($mappedRow, array(null));
    }

}
