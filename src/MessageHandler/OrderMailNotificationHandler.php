<?php

namespace App\MessageHandler;

use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Message\OrderMailNotification;
use App\Repository\OrderRepository;
use App\Service\OrderService;
use Doctrine\Common\Collections\Collection;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Email;

class OrderMailNotificationHandler implements MessageHandlerInterface
{
    private LoggerInterface $logger;
    private MailerInterface $mailer;
    private OrderRepository $orderRepository;

    private Order $order;
    private Customer $customer;

    public function __construct(LoggerInterface $logger, MailerInterface $mailer, OrderRepository $orderRepository)
    {
        $this->logger = $logger;
        $this->mailer = $mailer;
        $this->orderRepository = $orderRepository;
    }

    public function __invoke(OrderMailNotification $orderMailNotification)
    {
        $this->order = $this->orderRepository->findOneBy([
            'id' => $orderMailNotification->getOrderId()
        ]);
        $this->customer = $this->order->getCustomer();

        $this->sendMail();
    }

    /**
     * @param Collection<int, OrderProduct> $orderProducts
     * @return string
     */
    public function prepareHtml(): string
    {
        $html = '<table>';
        $html .= '<tr>';
        $html .= '<tr>';
            $html .= '<th>Ürün Adı</th>';
            $html .= '<th>Adet</th>';
            $html .= '<th>Birim Fiyatı</th>';
            $html .= '<th>Toplam</th>';
        $html .= '</tr>';
        $html .= '<tbody>';
        foreach ($this->order->getOrderProducts() as $orderProduct){
            $html .= '<tr>';
                $html .= '<td>'.$orderProduct->getProduct()->getName().'</td>';
                $html .= '<td>'.$orderProduct->getQuantity().'</td>';
                $html .= '<td>'.$orderProduct->getUnitPrice().'</td>';
                $html .= '<td>'.$orderProduct->getTotal().'</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';

        return $html;
    }

    public function sendMail()
    {
        $email = (new Email())
            ->from('muratcakmakis@yandex.com')
            ->to($this->customer->getMail())
            ->subject( $this->customer->getName().' Siparişiniz Bilgileriniz')
            ->text('Sipariş Bilgileriniz')
            ->html($this->prepareHtml());
        $this->mailer->send($email);
        $this->logger->info('Mail sent');
    }
}