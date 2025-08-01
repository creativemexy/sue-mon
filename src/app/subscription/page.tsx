"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import Subscription from "@/pages/Subscription";

export default function SubscriptionPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <Subscription />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 