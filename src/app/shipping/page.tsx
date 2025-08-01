"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import Shipping from "@/pages/Shipping";

export default function ShippingPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <Shipping />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 