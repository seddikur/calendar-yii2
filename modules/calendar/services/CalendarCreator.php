<?php declare(strict_types=1);

namespace app\modules\calendar\services;


class CalendarCreator
{
    /** @var int */
    private $creatorEmployeeId;
    /** @var CalendarModel */
    private $calendarModel;
    /** @var CalendarsFactory */
    private $calendarsFactory;
    /** @var CalendarsRepository */
    private $calendarsRepository;
    /** @var CalendarEventDispatcher */
    private $eventDispatcher;
    /** @var CalendarAccessRulesFactory */
    private $accessRulesFactory;
    /** @var CalendarAccessRulesRepository */
    private $accessRulesRepository;
    /** @var CalendarPermissionService */
    private $permissionService;

    /**
     * CalendarCreator constructor.
     * @param int                           $creatorEmployeeId
     * @param CalendarModel                 $calendarModel
     * @param CalendarsFactory              $calendarsFactory
     * @param CalendarsRepository           $calendarsRepository
     * @param CalendarAccessRulesFactory    $accessRulesFactory
     * @param CalendarAccessRulesRepository $accessRulesRepository
     * @param CalendarPermissionService     $permissionService
     * @param CalendarEventDispatcher       $eventDispatcher
     */
    public function __construct(
        int $creatorEmployeeId,
        CalendarModel $calendarModel,
        CalendarsFactory $calendarsFactory,
        CalendarsRepository $calendarsRepository,
        CalendarAccessRulesFactory $accessRulesFactory,
        CalendarAccessRulesRepository $accessRulesRepository,
        CalendarPermissionService $permissionService,
        CalendarEventDispatcher $eventDispatcher
    )
    {
        $this->creatorEmployeeId = $creatorEmployeeId;
        $this->calendarModel = $calendarModel;
        $this->calendarsFactory = $calendarsFactory;
        $this->calendarsRepository = $calendarsRepository;
        $this->eventDispatcher = $eventDispatcher;
        $this->accessRulesFactory = $accessRulesFactory;
        $this->accessRulesRepository = $accessRulesRepository;
        $this->permissionService = $permissionService;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function loadData(array $data): bool
    {
        return $this->calendarModel->load($data, '');
    }

    /**
     * @return Calendar
     */
    public function createCalendar(): Calendar
    {
        $this->calendarModel->validate();

        // Create calendar instance of required type
        $type = $this->calendarModel->type;
        if (Calendar::TYPE_ALIAS_PERSONAL === $type) {
            $calendar = $this->calendarsFactory->createPersonalCalendar($this->creatorEmployeeId);
        } elseif (Calendar::TYPE_ALIAS_COMPANY === $type) {
            $calendar = $this->calendarsFactory->createCompanyCalendar($this->creatorEmployeeId);
        } else {
            throw new \DomainException('Unable to create calendar: unknown type ' . $type);
        }

        if (!$this->permissionService->isEmployeeCanAddEventsToCalendar($calendar, $this->creatorEmployeeId)) {
            throw new CalendarPermissionException('создавать события в календаре ' . $calendar->getTitle());
        }

        $this->calendarModel->loadDataIntoCalendarEntity($calendar);
        $this->calendarsRepository->save($calendar);

        $this->eventDispatcher->enqueueEvent(
            CalendarCreatedCalendarEvent::class,
            $calendar,
            $this->creatorEmployeeId
        );

        $this->saveAccessRules($calendar);

        $this->eventDispatcher->releaseEvents();
        return $calendar;
    }

    /**
     * @param Calendar $calendar
     */
    private function saveAccessRules(Calendar $calendar): void
    {
        $idsContainer = [];
        foreach ($this->calendarModel->accessRules as $rule) {
            $rule = $this->accessRulesFactory->createRule(
                (string)$rule['type'],
                (int)$rule['entityId'],
                $rule['permissions']
            );
            $rule->setCalendarId($calendar->id);
            $this->accessRulesRepository->save($rule);
            $idsContainer[] = $rule->getAffectedEmployeeIds();
        }

        if (\count($idsContainer)) {
            $this->eventDispatcher->enqueueEvent(
                CalendarAccessGrantedCalendarEvent::class,
                $calendar,
                $this->creatorEmployeeId,
                [array_merge(...$idsContainer)]
            );
        }
    }
}
