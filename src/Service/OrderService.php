<?php

namespace App\Service;

use App\Entity\Order;
use App\Message\OrderMailNotification;
use App\Repository\OrderRepository;
use Exception;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\SerializerInterface;

class OrderService extends BaseService
{
    private CustomerService $customerService;
    private OrderProductService $orderProductService;
    private CartService $cartService;
    private DiscountService $discountService;
    private OrderDiscountHistoryService $orderDiscountHistoryService;
    private MessageBusInterface $bus;

    /**
     * @throws Exception
     */
    public function __construct(OrderRepository             $repository, SerializerInterface $serializer,
                                CustomerService             $customerService, OrderProductService $orderProductService,
                                CartService                 $cartService, DiscountService $discountService,
                                OrderDiscountHistoryService $orderDiscountHistoryService, MessageBusInterface $bus)
    {
        $this->repository = $repository;
        $this->serializer = $serializer;
        $this->customerService = $customerService;
        $this->orderProductService = $orderProductService;
        $this->cartService = $cartService;
        $this->discountService = $discountService;
        $this->orderDiscountHistoryService = $orderDiscountHistoryService;
        $this->em = $this->repository->getEntityManager();
        $this->bus = $bus;
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param bool $notFoundException
     * @return Order|null
     * @throws Exception
     */
    public function getOrder(array $criteria, array $orderBy = null, bool $notFoundException = true): ?Order
    {
        return $this->findOneBy($criteria, $orderBy, $notFoundException);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param $limit
     * @param $offset
     * @return Order[]
     */
    public function getOrderBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Müşterinin siparişindeki tüm ürün bilgilerini döner.
     * @return mixed
     * @throws Exception
     */
    public function index()
    {
        return json_decode($this->serializer->serialize($this->repository->findAll(), 'json', [
            'groups' => ['order', 'orderOrderProductRelation', 'orderProduct', 'orderOrderDiscountHistoryRelation', 'orderDiscountHistory']
        ]));
    }

    /**
     * Siparisi kaydini tamamlar
     * @param array $attributes
     * @return void
     */
    public function complete(array $attributes)
    {
        $this->em->transactional(function () use ($attributes) {
            $cart = $this->cartService->getDefaultCart();
            $cartProducts = $cart->getCartProducts();

            if (count($cartProducts) <= 0) { //sepette urun var mi ?
                throw new Exception('Cart is empty');
            }

            if (isset($attributes['discount_id'])) { //Indirim mevcut mu ?
                $discountAnalysisWithDiscount = $this->discountService->getDiscountAnalysisWithDiscount($attributes['discount_id']); //secilen indirimin uygulanmasi
                $discount = $discountAnalysisWithDiscount['discount']; //indirim bilgileri
                $subTotal = $discountAnalysisWithDiscount['discountAnalysis']['subtotal']; //indirimli tutar bilgisi
            }

            //Yeni siparis acilmasi sepet bilgilerine gore acilmasi
            $order = $this->store([
                'subtotal' => $subTotal ?? $cart->getTotal(),
                'total' => $cart->getTotal(),
                'customer' => $this->customerService->getCustomerTest()
            ]);

            if (isset($discount)) { //Siparişe ait indirim geçmişinin tutulması
                $this->orderDiscountHistoryService->store([
                    'order' => $order,
                    'name' => $discount->getName(),
                    'description' => $discount->getDescription(),
                    'jsonData' => $discount->getJsonData(false)
                ]);
            }

            //Sepetteki urunlerin siparise aktarilmasi
            foreach ($cartProducts as $cartProduct) {
                $this->orderProductService->addCartProductToOrderProduct($order, $cartProduct);
            }

            //Sepetin silinmesi
            $this->cartService->remove($cart);

            //Siparisin bilgilerinin mail oalrak gonderilmesi
            $this->sendOrderMailNotification($order->getId());
        });
    }

    /**
     * @param int $orderId
     * @return void
     */
    public function sendOrderMailNotification(int $orderId)
    {
        $this->bus->dispatch(new OrderMailNotification($orderId));
    }
}