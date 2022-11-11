<?php

namespace Unit\Modules\Vendas;

use dev\Dependencies\Adapters\Logger\MonologLogAdapter;
use dev\Modules\Vendas\Creation\Exceptions\ParserFileException;
use dev\Modules\Vendas\Creation\Exceptions\SaveVendaException;
use dev\Modules\Vendas\Creation\Requests\Request as VendaRequest;
use dev\Modules\Vendas\Creation\UseCase;
use dev\Modules\Vendas\Generics\Entities\Vendas;
use dev\Modules\Vendas\Generics\Gateways\VendaGateway;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class VendasTest extends TestCase
{
    private MockObject $vendaGateway;
    private MockObject $loggerMock;
    private UseCase $useCase;

    public function setUp(): void
    {
        $this->vendaGateway = $this->createMock(VendaGateway::class);
        $this->loggerMock = $this->createMock(MonologLogAdapter::class);

        $this->useCase = new UseCase($this->vendaGateway, $this->loggerMock);
    }

    public function testSuccess()
    {
        $this->vendaGateway->expects($this->once())
            ->method('save');

        $this->vendaGateway->expects($this->once())
            ->method('save');

        $this->useCase = new UseCase($this->vendaGateway, $this->loggerMock);

        $venda = (new Vendas())
            ->setArquivo(
                "data:text/plain;base64,Q29tcHJhZG9yCURlc2NyacOnw6NvCVByZcOnbyBVbml0w6FyaW8JUXVhbnRpZGFkZQlFbmRlcmXDp28JRm9ybmVjZWRvcgpKb8OjbyBTaWx2YQlSJDEwIG9mZiBSJDIwIG9mIGZvb2QJMTAuMAkyCTk4NyBGYWtlIFN0CUJvYidzIFBpenphCkFteSBQb25kCVIkMzAgb2YgYXdlc29tZSBmb3IgUiQxMAkxMC4wCTUJNDU2IFVucmVhbCBSZAlUb20ncyBBd2Vzb21lIFNob3AKTWFydHkgTWNGbHkJUiQyMCBTbmVha2VycyBmb3IgUiQ1CTUuMAkxCTEyMyBGYWtlIFN0CVNuZWFrZXIgU3RvcmUgRW1wb3JpdW0KU25ha2UgUGxpc3NrZW4JUiQyMCBTbmVha2VycyBmb3IgUiQ1CTUuMAk0CTEyMyBGYWtlIFN0CVNuZWFrZXIgU3RvcmUgRW1wb3JpdW0K"
            );
        $request = new VendaRequest($venda);

        $this->useCase->execute($request);

        $this->assertEquals(201, $this->useCase->getResponse()->getStatus()->getCode());
    }

    public function testSaveUserError()
    {
        $this->expectException(SaveVendaException::class);

        $this->vendaGateway = $this->createMock(VendaGateway::class);
        $loggerMock = $this->createMock(MonologLogAdapter::class);

        $this->vendaGateway->expects($this->once())
            ->method('save')
            ->willThrowException(new \Exception('Cannot save'));

        $this->useCase = new UseCase($this->vendaGateway, $loggerMock);

        $venda = (new Vendas())
            ->setArquivo(
                "data:text/plain;base64,Q29tcHJhZG9yCURlc2NyacOnw6NvCVByZcOnbyBVbml0w6FyaW8JUXVhbnRpZGFkZQlFbmRlcmXDp28JRm9ybmVjZWRvcgpKb8OjbyBTaWx2YQlSJDEwIG9mZiBSJDIwIG9mIGZvb2QJMTAuMAkyCTk4NyBGYWtlIFN0CUJvYidzIFBpenphCkFteSBQb25kCVIkMzAgb2YgYXdlc29tZSBmb3IgUiQxMAkxMC4wCTUJNDU2IFVucmVhbCBSZAlUb20ncyBBd2Vzb21lIFNob3AKTWFydHkgTWNGbHkJUiQyMCBTbmVha2VycyBmb3IgUiQ1CTUuMAkxCTEyMyBGYWtlIFN0CVNuZWFrZXIgU3RvcmUgRW1wb3JpdW0KU25ha2UgUGxpc3NrZW4JUiQyMCBTbmVha2VycyBmb3IgUiQ1CTUuMAk0CTEyMyBGYWtlIFN0CVNuZWFrZXIgU3RvcmUgRW1wb3JpdW0K"
            );
        $request = new VendaRequest($venda);

        $this->useCase->execute($request);
    }

    public function testParserFileError()
    {
        $this->expectException(ParserFileException::class);

        $this->vendaGateway = $this->createMock(VendaGateway::class);
        $loggerMock = $this->createMock(MonologLogAdapter::class);

        $this->vendaGateway->expects($this->never())
            ->method('save');

        $this->useCase = new UseCase($this->vendaGateway, $loggerMock);

        $venda = (new Vendas())
            ->setArquivo(
                ""
            );
        $request = new VendaRequest($venda);

        $this->useCase->execute($request);
    }
}
